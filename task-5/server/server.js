const PROTO_PATH = "./notes.proto";

const grpc = require("grpc")
const protoloader = require("@grpc/proto-loader")
const conn = require("../database/conn");



const packageDefinition = protoloader.loadSync(
    PROTO_PATH,
    {
        keepCase: true,
        longs: String,
        enums: String,
        defaults: true,
        oneofs: true
})

const notesProto = grpc.loadPackageDefinition(packageDefinition)

const { v4:uuidv4} = require("uuid");

const server = new grpc.Server()


server.addService(notesProto.NoteService.service,{
    getAll:(_,callback)=>{
        conn.query('SELECT * FROM notes',(err,rows,fields)=>{
            if(err){ console.log(err)}            
            let notes = []             
            for(let key in rows){
                notes.push({
                    "id":rows[key].id,
                    "todo":rows[key].todo
                });
            }  
            console.log({notes})       
            callback(null,{notes})                              
        })             
    },
    get:(call,callback)=>{
        let noteId = call.request.id;
        console.log(noteId);
        conn.query('SELECT * FROM notes WHERE id=?',[noteId],(err,rows,fields)=>{
            if(err) throw err;
            console.log(rows)
            if(rows != []){
                let note = {
                    "id":rows[0].id,
                    "todo":rows[0].todo
                }
                console.log({note});
                callback(null,note);
            }else{
                callback(true,{
                    code: grpc.status.NOT_FOUND,
                    details: "Not found"
                });
            }              
        })
    },
    insert:(call,callback)=>{
        let note = call.request;
        conn.query('INSERT INTO notes (todo) VALUES(?)',[note.todo],(err,rows,fields)=>{
            if(err) throw err;    
            if(rows){
                console.log(rows.insertId) 
                note = {"id":rows.insertId,"todo":note.todo}                             
                callback(null,note);
            }else{
               
            }         
        });      
    },
    update:(call,callback)=>{
        let note = call.request;
        conn.query('UPDATE notes SET todo=? WHERE id=?',[note.todo,note.id],(err,rows,fields)=>{
            if(err) throw err;
            if(rows.changedRows>0){
                console.log(rows);      
                note = {"id":note.id,"todo":note.todo}                             
                callback(null,note);          
            }else{
                callback(true,{
                    code: grpc.status.NOT_FOUND,
                    details: "Not found"
                });
            }
        })
    },
    delete:(call,callback)=>{
        let noteId = call.request.id;
        conn.query('DELETE FROM notes WHERE id=?',[noteId],(err,rows,fields)=>{
            if(err) throw err;
            console.log(rows.affectedRows);
            if(rows.affectedRows != 0){
                console.log("berhaisl");
                callback(null,{})
            }
            else{
                console.log("gagal");
                callback(true,{
                    code: grpc.status.NOT_FOUND,
                    details: "Not found"
                });
            }
        })
    }

})

server.bind("127.0.0.1:8082",grpc.ServerCredentials.createInsecure())
console.log("running at localhost:8082")
server.start()

