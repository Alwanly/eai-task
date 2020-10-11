const PROTO_PATH ="./notes.proto";

const grpc = require("grpc");
const protoLoader = require("@grpc/proto-loader");
const express = require("express");
const bodyParser = require("body-parser");

const app= express();

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({extended:false}))

let packageDefinition = protoLoader.loadSync(
    PROTO_PATH,{
        keepCase:true,
        longs:String,
        enums:String,
        arrays:true
    });

const NoteSerivers = grpc.loadPackageDefinition(packageDefinition).NoteService
const client = new NoteSerivers("localhost:8082",grpc.credentials.createInsecure())

app.get("/notes",(req,res)=>{
    client.getAll(null,(err,data)=>{    
        if(!err) res.json({status:true,message:"Success",notes:data.notes});
        else {res.json({status:false,message:"Data Not Found"})}
    })
})

app.get("/note/:id",(req,res)=>{
    const noteId = {id:req.params.id};
    client.get(noteId,(err,data)=>{
        if(!err) res.json({status:true,message:"Success",note:data});
        else {res.json({status:false,message:"Data Not Found"})}
    })

})

app.post("/save",(req,res)=>{
    let note = {
        todo:req.body.todo
    }
    client.insert(note,(err,data)=>{
        if(!err) res.json({status:true,message:"Insert Success",note:data});
        else {res.json({status:false,message:"Insert Failed"})}
        console.log("berhasil",data)
        
    })
})
app.put("/update",(req,res)=>{
    let note = {id:req.body.id,todo:req.body.todo}
    client.update(note,(err,data)=>{
        console.log("terupdaet",data)
        if(!err) res.json({status:true,message:"Insert Success",note:data});
        else {res.json({status:false,message:"Data tidak ditemukan"})}

    })
})
app.delete("/delete",(req,res)=>{
    let noteId = {id:req.body.id}
    client.delete(noteId,(err,data)=>{
        if(!err){res.json({status:true,message:"Delete Success"})}
        else {res.json({status:false,message:"Data tidak ditemukan"})}
    })
})

const PORT = 3030;
app.listen(PORT,()=>{
    console.log("running at POrt ",PORT)
})