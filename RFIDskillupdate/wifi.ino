void connectWiFi() {
  Serial.println("Connecting to Wifi");
  WiFi.mode(WIFI_STA);
//  WiFi.config(ip, gateway, subnet); 
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) 
  {
    digitalWrite(D1,HIGH);
    if(counter > 15)
    {
      Serial.println("- can't connect, going to sleep");
       wificonnect = false;
       digitalWrite(D1,LOW);    
      // hibernate(failConnectRetryInterval);
    }
   delay(300);
    digitalWrite(D1,LOW);
    Serial.print(".");
    delay(300);
    digitalWrite(D1,HIGH);
    counter++;
  }
  if(WiFi.status() == WL_CONNECTED)
  {
  Serial.print(ssid);  
  Serial.println(" connected");
  wificonnect = true;
  digitalWrite(D1,HIGH); // data sending to delta
  }
  }
void connecthost()
{
  counter=0;
  gtfo=false;
  Serial.print("connecting to ");
  Serial.println(host);
  
  WiFiClient client; //Client to handle TCP Connection
  const int httpPort = 80;
  if (!client.connect(host, httpPort)) { //Connect to server using port httpPort
    Serial.println("connection failed");
    //return;
    digitalWrite(D7,HIGH);}


  client.print(String("GET ") + url + " HTTP/1.1\r\n" +
               "Host: " + host + "\r\n" +
               "Accept: */*"+"\r\n"+
               "Connection: close\r\n\r\n");
                t1=millis();
  //
              
  unsigned long timeout = millis();
  while (client.available() == 0) {
    if (millis() - timeout > 25000) { //Try to fetch response for 25 seconds
      Serial.println(">>> Client Timeout !");
      client.stop();
      return;
    }
  }
  
  // Read all the lines of the reply from server and print them to Serial
  counter=0;
  while(client.available())
  {
    
    // String line = client.readStringUntil('\r');
    
    char in1 = client.read();
    line+=in1;
    counter++;
//    led=true;
    Serial.print(in1);
    }
    //Serial.print(line);
    Serial.println("");
    Serial.println("********************************");
   //Serial.print(line);
  Serial.println();
  Serial.println("closing connection");
  client.stop(); //Close Connection
  t2=millis();
  t1=t2-t1;
  Serial.print("Time Taken ");
  Serial.println(t1/1000);
  Serial.print("Total String Length ");
  Serial.println(counter);
 
}
