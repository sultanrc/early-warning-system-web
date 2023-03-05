#include <DHT.h>
#include <ESP8266WiFi.h>
#include <LiquidCrystal_I2C.h>
// #include <SMTP.h>

//Define DHT11
#define DHT11PIN D7
#define DHTTYPE DHT11

//
#define LED_pin1 D5
#define LED_pin2 D8

DHT dht(DHT11PIN, DHTTYPE, 15);
LiquidCrystal_I2C lcd(0x27, 20, 2); // CHANGE THE 0X27 ADDRESS TO YOUR SCREEN ADDRESS IF NEEDED

String apiKey = "KFZ34WQXEQN8BMYL";
const char* ssid = "SysAdmin";
const char* password = "Sys@dm1n123";
const char* server = "api.thingspeak.com";
WiFiClient client;

void setup() {
  //Setup LED, Serial, DHT, LCD
  pinMode(LED_pin1, OUTPUT);
  pinMode(LED_pin2, OUTPUT);
  Serial.begin(9600);
  dht.begin();
  lcd.begin(16,2);
  lcd.init();
  lcd.noBacklight();

  //Loop WiFi Connection
  WiFi.begin(ssid, password);
  while(WiFi.status() != WL_CONNECTED){
    digitalWrite(LED_pin1, HIGH);
    Serial.print("WiFi Not Connected");
    delay(500);
    digitalWrite(LED_pin1, LOW);
  }

  //LCD, Lampu D6 Hidup Jika Koneksi Wifi Berhasil
  lcd.backlight();
  digitalWrite(LED_pin2, HIGH);
}

void loop() {
  //Read Temperature and Humidity
  float suhu = dht.readTemperature();
  float lembab = dht.readHumidity();
  lcd.clear();
  lcd.print("TEMP  : ");
  lcd.print(suhu);
  lcd.print((char)223);
  lcd.print("C");
  lcd.setCursor(0,1);
  lcd.print("HUMID : ");
  lcd.print(lembab);
  lcd.print("%");
  Serial.print("Temperature ");
  Serial.print(suhu);
  Serial.print("°C");
  Serial.print(" Humidity ");
  Serial.print(lembab);
  Serial.println("%");
  delay(2000);
}
