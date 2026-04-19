#include <TinyGPSPlus.h>
#include <ArduinoJson.h>
#define ss Serial1
static const uint32_t GPSBaud = 9600;

const int relay1Pin = 6;
const int buzzerPin = 8; 

TinyGPSPlus gps;

unsigned long lastSwitchTime = 0;
const unsigned long interval = 5000;
bool relay1Active = true;

int id_kendaraan = 50;

#define TINY_GSM_MODEM_SIM7000
#define Serial Serial

#ifndef __AVR_ATmega328P__
#define SerialAT Serial2
#else
#include <SoftwareSerial.h>
SoftwareSerial SerialAT(2, 3);
#endif

#if !defined(TINY_GSM_RX_BUFFER)
#define TINY_GSM_RX_BUFFER 650
#endif

#define TINY_GSM_DEBUG Serial
#define GSM_AUTOBAUD_MIN 9600
#define GSM_AUTOBAUD_MAX 115200
#define TINY_GSM_USE_GPRS true
#define TINY_GSM_USE_WIFI false
#define GSM_PIN ""

const char apn[]      = "Internet";
const char gprsUser[] = "";
const char gprsPass[] = "";

const char server[]   = "rentalmotorpalembang.com";
const int  port       = 80;

#include <TinyGsmClient.h>
#include <ArduinoHttpClient.h>

#if TINY_GSM_USE_GPRS && not defined TINY_GSM_MODEM_HAS_GPRS
#undef TINY_GSM_USE_GPRS
#undef TINY_GSM_USE_WIFI
#define TINY_GSM_USE_GPRS false
#define TINY_GSM_USE_WIFI true
#endif
#if TINY_GSM_USE_WIFI && not defined TINY_GSM_MODEM_HAS_WIFI
#undef TINY_GSM_USE_GPRS
#undef TINY_GSM_USE_WIFI
#define TINY_GSM_USE_GPRS true
#define TINY_GSM_USE_WIFI false
#endif

TinyGsm modem(SerialAT);
TinyGsmClient client(modem);
HttpClient http(client, server, port);

unsigned long buzzerStartTime = 0;
bool buzzerActive = false;
bool buzzerBlinkState = false;
unsigned long lastBlinkTime = 0;
const unsigned long buzzerBlinkInterval = 500;
const unsigned long buzzerDuration = 30000;

void setup() {
  Serial.begin(115200);
  ss.begin(GPSBaud);

  pinMode(relay1Pin, OUTPUT);
  pinMode(buzzerPin, OUTPUT);
  
  digitalWrite(relay1Pin, LOW);
  digitalWrite(buzzerPin, LOW); 

  Serial.println(F("GPS + Relay Alternating Control (Serial1)"));

  TinyGsmAutoBaud(SerialAT, GSM_AUTOBAUD_MIN, GSM_AUTOBAUD_MAX);
  delay(6000);

  Serial.println("Initializing modem...");
  modem.restart();

  String modemInfo = modem.getModemInfo();
  Serial.print("Modem Info: ");
  Serial.println(modemInfo);

#if TINY_GSM_USE_GPRS
  if (GSM_PIN && modem.getSimStatus() != 3) {
    modem.simUnlock(GSM_PIN);
  }
#endif
}

void kirim_data(float data_lat, float data_lng, int data_id) {
#if TINY_GSM_USE_GPRS
  Serial.print(F("Connecting to "));
  Serial.print(apn);
  if (!modem.gprsConnect(apn, gprsUser, gprsPass)) {
    Serial.println(" fail");
    delay(100);
    return;
  }
  Serial.println(" success");
  if (modem.isGprsConnected()) {
    Serial.println("GPRS connected");
  }
#endif

  String url = "/api/proses_data?latitude=" + String(data_lat, 6) +
               "&longitude=" + String(data_lng, 6) +
               "&id_kendaraan=" + String(data_id);

  Serial.print(F("Performing HTTP GET request to: "));
  Serial.println(url);

  int err = http.get(url);
  if (err != 0) {
    Serial.println(F("failed to connect"));
    delay(10000);
    return;
  }

  int status = http.responseStatusCode();
  Serial.print(F("Response status code: "));
  Serial.println(status);
  if (!status) {
    delay(10000);
    return;
  }

  String body = http.responseBody();
  Serial.println(F("Response:"));
  Serial.println(body);

  StaticJsonDocument<200> doc;
  DeserializationError error = deserializeJson(doc, body);
  if (error) {
    Serial.print(F("JSON parse failed: "));
    Serial.println(error.f_str());
    return;
  }

  if (!doc["status"]) {
    String msg = doc["message"];
    if (msg == "Kendaraan Tidak Sedang Disewa") {
      digitalWrite(relay1Pin, LOW);
      buzzerActive = false;
      digitalWrite(buzzerPin, LOW);
      Serial.println("❌ Kendaraan tidak disewa. Buzzer dimatikan.");
      return;
    }
  }

  bool isLokasi = doc["data"]["status_lokasi"];
  bool isWaktu = doc["data"]["status_waktu"];
  bool isBuzzer = doc["data"]["status_buzzer"];

  digitalWrite(relay1Pin, (isLokasi && isWaktu) ? HIGH : LOW);

  if (isBuzzer) {
    buzzerActive = true;
    buzzerStartTime = millis();
    lastBlinkTime = millis();
    Serial.println("🔔 Buzzer AKTIF sesuai perintah server");
  } else {
    buzzerActive = false;
    digitalWrite(buzzerPin, LOW);
    Serial.println("🔕 Buzzer MATI sesuai perintah server");
  }

  http.stop();
  Serial.println(F("Server disconnected"));
#if TINY_GSM_USE_WIFI
  modem.networkDisconnect();
  Serial.println(F("WiFi disconnected"));
#endif
#if TINY_GSM_USE_GPRS
  modem.gprsDisconnect();
  Serial.println(F("GPRS disconnected"));
#endif
}

void loop() {
  while (ss.available()) {
    gps.encode(ss.read());
  }

  if (gps.location.isUpdated()) {
    Serial.print("Lat: "); Serial.println(gps.location.lat(), 6);
    Serial.print("Lon: "); Serial.println(gps.location.lng(), 6);
    Serial.print("Speed: "); Serial.println(gps.speed.kmph());
    Serial.println("--------------------------");
  }

  unsigned long currentTime = millis();
  if (currentTime - lastSwitchTime >= interval) {
    lastSwitchTime = currentTime;
    relay1Active = !relay1Active;
    if (gps.location.isValid()) {
      kirim_data(gps.location.lat(), gps.location.lng(), id_kendaraan);
    } else {
      Serial.println("GPS belum fix, tidak mengirim data.");
    }
  }

  if (buzzerActive) {
    if (millis() - buzzerStartTime < buzzerDuration) {
      if (millis() - lastBlinkTime >= buzzerBlinkInterval) {
        lastBlinkTime = millis();
        buzzerBlinkState = !buzzerBlinkState;
        digitalWrite(buzzerPin, buzzerBlinkState);
      }
    } else {
      buzzerActive = false;
      digitalWrite(buzzerPin, LOW);
    }
  }

  delay(100);
}

