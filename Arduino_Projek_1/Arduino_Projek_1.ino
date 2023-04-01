#include <DHT.h>
#include <ESP8266WiFi.h>
#include <LiquidCrystal_I2C.h>
#include "TRIGGER_WIFI.h"
#include "TRIGGER_GOOGLESHEETS.h"

#define SENSORPIN D5
#define DHT11PIN D7
#define DHTTYPE DHT11
#define LED_pin1 D6
#define LED_pin2 D8

char column_name_in_sheets[ ][20] = {"value1","value2","value3"};  /*1. The Total no of column depends on how many value you have created in Script of Sheets;2. It has to be in order as per the rows decided in google sheets*/
String Sheets_GAS_ID = "AKfycbxWtcVRGbqkdigN3VW5OYN19JHZXI3B0zyvsOmpkRb4Uw5uSaC6vMJXChBl0y3RC9G7DQ";
int No_of_Parameters = 3;

int readsensor = 0
float humidity = 0;
float temprature = 0;
float firedity = 0;

DHT dht(DHT11PIN, DHTTYPE, 15);
LiquidCrystal_I2C lcd(0x27, 20, 2); // CHANGE THE 0X27 ADDRESS TO YOUR SCREEN ADDRESS IF NEEDED

String apiKey = "KFZ34WQXEQN8BMYL";
const char* ssid = "SysAdmin";
const char* password = "Sys@dm1n123";

void setup() {
  //Setup LED, Serial, DHT, LCD
  pinMode(LED_pin1, OUTPUT);
  pinMode(LED_pin2, OUTPUT);
  pinMode(SENSORPIN, INPUT);
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
  WIFI_Connect(ssid, password);
  Google_Sheets_Init(column_name_in_sheets, Sheets_GAS_ID, No_of_Parameters );
  //LCD, Lampu D6 Hidup Jika Koneksi Wifi Berhasil
  lcd.backlight();
  digitalWrite(LED_pin1, HIGH);
}

void showDatainLCD(float Humidity, float Temperature){
  lcd.clear();
  lcd.print("TEMP  : ");
  lcd.print(Temperature);
  lcd.print((char)223);
  lcd.print("C");
  lcd.setCursor(0,1);
  lcd.print("HUMID : ");
  lcd.print(Humidity);
  lcd.print("%");
}

void loop() {
  //Read Temperature and Humidity
  humidity = dht.readTemperature();
  temperature = dht.readHumidity();

  showDatainLCD(humidity, temperature);

  //blok kode untuk mengecek sensor api
  int i = 0;
  firedity = 0;
  while(i<30){ //0 = fire, 1 = no fire
    readsensor = digitalRead(SENSORPIN);
    if (readsensor == 1){
      delay(10000);
      i++;
      continue;
    }
    firedity = 1;
    break;
  }

  temprature = dht.readTemperature();
  humidity = dht.readHumidity();
  Data_to_Sheets(No_of_Parameters,  Humidity,  Temperature,  firedity);
  
  if (readsensor == 0) delay (300000);
}
