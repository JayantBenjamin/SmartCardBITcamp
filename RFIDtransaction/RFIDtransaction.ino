#include <deprecated.h>
#include <MFRC522.h>
#include <MFRC522Debug.h>
#include <MFRC522Extended.h>
#include <MFRC522Hack.h>
#include <require_cpp11.h>

#include <SPI.h>
#include <MFRC522.h>

//////////Wifi lib
#include <ESP8266WiFi.h>
#include <WiFiClient.h>
constexpr uint8_t RST_PIN = 5;          //reset pin ka data to d1 in nodemcu check karliyo
constexpr uint8_t SS_PIN = 4;         // SS pin ka data to d2 in node mcu

int statuss = 0;
int out = 0;
String content= "";
String UIDIDI="";
String UIDIDILAST="";
////Wifi constants 
// WiFi information
const char ssid[] = "nigawut"; //Wifi Name ssid   
const char password[]  = "yelepassword"; //password 
String line="";
//Only used if using Static IP
IPAddress ip(192, 168, 0, 6); //IP
IPAddress gatewayDNS(192, 168, 0, 1);//DNS and Gewateway
IPAddress netmask(255, 255, 255,0); //Netmask

//Server IP or domain name
const char* host = "jayantbenjamin.000webhostapp.com"; //host
//http://<my-local-subnet-host>:80/foo.html
 // constants
int counter,i,j,b;   //wow it was in sleep mode 
float t1,t2;
boolean wificonnect = false;
char webstring [2];
boolean gtfo =false;
const char* check="z";
int a[5];
String url="";
// Global variables
WiFiClient client;
MFRC522 mfrc522(SS_PIN, RST_PIN); //instance 

void setup() 
{
  Serial.begin(9600);    
  while (!Serial);    // Do nothing if no serial port is opened (added for Arduinos based on ATMEGA32U4)
  SPI.begin();      
  mfrc522.PCD_Init();   //MFRC522 ka initialization
  mfrc522.PCD_DumpVersionToSerial();  // details of PCD - MFRC522 Card Reader details
  Serial.println(F("Scan PICC to see UID, SAK, type, and data blocks for further understanding"));
  connectWiFi();
}


void readID()
{
  byte letter;
      
  Serial.println("Read ID Function Call huaaa");
  //Serial.println(content.substring(1,24));
  for (byte i = 0; i < mfrc522.uid.size; i++) 
          {
            Serial.print(mfrc522.uid.uidByte[i] < 0x10 ? " 0" : " ");
            Serial.print(mfrc522.uid.uidByte[i], HEX);
            content.concat(String(mfrc522.uid.uidByte[i] < 0x10 ? " 0" : " "));
            content.concat(String(mfrc522.uid.uidByte[i], HEX));
          }
            content.toUpperCase();
            String UIDIDI= content.substring(1,24);
            Serial.println();
            Serial.println(UIDIDI);
            if((UIDIDI!=0)&&(UIDIDI!=UIDIDILAST))
            {
                Serial.println("New stuff");
                String item="";
                item+=UIDIDI[0];
                item+=UIDIDI[1];
                item+=UIDIDI[3];
                item+=UIDIDI[4];
                item+=UIDIDI[6];
                item+=UIDIDI[7];
                item+=UIDIDI[9];
                item+=UIDIDI[10];
                
                Serial.println(item);
                url="http://jayantbenjamin.000webhostapp.com/RAIThack/giveOTP.php?UID=";
                url+=item;
                Serial.println(url);
                connecthost();
                Serial.println("**************########*************");
            
            }
                UIDIDILAST=UIDIDI;
                int str_len = UIDIDI.length() + 1; 

                // Prepare the character array (the buffer) 
                char char_array[str_len];

                // Copy it over 
                UIDIDI.toCharArray(char_array, str_len);
                /*char charBuf[50];
                UIDIDI.toCharArray(charBuf, 50)
                Serial.println(UIDIDI);
            */          
}

void loop() 
{
    if ( ! mfrc522.PICC_IsNewCardPresent()) //will show data if a new card browsed over the device PICC_ReadCardSerial()
    {
      //Serial.println("New Card Found");
      Serial.println();
      Serial.println("ye void loop mein new card waala function hei");
      //Serial.print(" UID tag :");
      
      /*for (byte i = 0; i < mfrc522.uid.size; i++) 
          {
            Serial.print(mfrc522.uid.uidByte[i] < 0x10 ? " 0" : " ");
            Serial.print(mfrc522.uid.uidByte[i], HEX);
            content.concat(String(mfrc522.uid.uidByte[i] < 0x10 ? " 0" : " "));
            content.concat(String(mfrc522.uid.uidByte[i], HEX));
          }
                   content.toUpperCase();//get the uid letters to upper case now
       */
                  readID();
                  Serial.println("Read id se value call hua hei 2 baar aana chaiye");
                  Serial.println("*********************************************************\n");
                 
                 Serial.println(UIDIDI);

                   
                  if (content.substring(1) == "83 4B 25 D9") //UID no. to compare for payment
                 {
                  Serial.println("Compare successful hua");
                   Serial.println(" Access Granted ");
                   Serial.println(" Thank you for payment/adding the skill ");
                   delay(1000);
                   Serial.println(" Please check your updates on the mobile for further details ");
                   Serial.println();
                   statuss = 1;
                 }
  
                  else  
                   {
                      Serial.println(" Card not detected yet/galat card hei ");
                      delay(3000);
                    }
                   content = "";
                    
 }
  if ( ! mfrc522.PICC_ReadCardSerial()) //will show data when same card presented again
  {
    Serial.println("Card already user yaaaaar ye chal raha hei bc##########");
    return;
  }

  // Dump debug info about the card;
  //mfrc522.PICC_DumpToSerial(&(mfrc522.uid));

}

