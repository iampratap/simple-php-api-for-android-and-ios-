# simple-php-api-for-android-and-ios

method is post

#1.type = login

var string type = login;

var where = where;                     // for datafild name such like username, email or mobile, it will replace where;

var username = username;         // it will filter from datafild name given <where> 

var password = password;          //Password

 

The query will like 

SELECT * FROM `user` WHERE `<where>` LIKE '<username>' AND `password` LIKE '<password>' 
 

On Success it will return JSON string

 {['error' => 0, 'result' => ['id' => '1', 'key' => 'key3k4ji45kj3hi4yhrf90']]}
on error it will return JSON 

{['error' => 1, 'result' => 0]}
 

#2.type =  GET

var string type = GET;

var key = key;                     // Key form login function;

var sql = Query;         // A valide SQL query.

 

On Success it will return JSON string

 {['error' => 0, 'result' => 'JSON STRING OF DATA'}
on error it will return JSON 

{['error' => 1, 'result' => 'Mysql Error']}
 

#3.type = SET

var string type = SET;

var key = key;                     // Key form login function;

var sql = Query;         // A valide SQL query.

 

On Success it will return JSON string

 {['error' => 0, 'result' => 'success'}
on error it will return JSON 

{['error' => 1, 'result' => 'Mysql Error']}
 

#4. type = upload

var string type = uplead;

var key = key;                     // Key form login function;

var path= path;         // folder name where file will store such as userid or username.

var file= file;         // File to Upload.


On Success it will return JSON string

 {['error' => 0, 'result' => 'file link'}
on error it will return JSON 

{['error' => 1, 'result' => 'Error To Upload File']}
 

#5. type = delete

var string type = uplead;

var key = key;                     // Key form login function;

var path= path;         //Link Of file which to be deleted

.

On Success it will return JSON string

 {['error' => 0, 'result' => 'Deleted'}
on error it will return JSON 

{['error' => 1, 'result' => 'Error To Delete File']}
