# Tyl Documenation

The official documentation from Tyl is not completely up to date, so some clarifications. 



## Server to Server notifications

Using the payload from Tyl in combination with the Store Name and Shared secret. Concatenate the following values with a pipe `|` character. 

From Tyl Support 
```
Notification hash for server-to-server notification (using a transactionNotificationURL)
The notification_hash, which is sent in a server-to-server response, is calculated as follows --

SHA256 algorithm
Parameter expected: "notification_hash"
Concatenated string format: chargetotal + sharedsecret + currency + txndatetime + storename + approval_code

HMACSHA256 algorithm
Parameter expected: "notification_hash"
Concatenated string format: chargetotal|currency|txndatetime|storename|approval_code

Regarding the extended response hash, this is turned off by default, please may you confirm your store ID and we can make the amendment so that this would be enabled for your store?
```
