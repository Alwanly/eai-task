const mysql = require("mysql");

module.exports = conn = mysql.createConnection({
    host:"localhost",
    user:"root",
    password:"",
    database:"simple"
});

conn.connect((err)=>{
    if(err) throw err;
    console.log("Connection Berhasil");
})