<?php

require_once '../../plugin/phpsqlparser/PHPSQLParser.php';


class Cruder {
    
    var $miParser;
    var $miFormCreator;
    var $miFormRetrieve;
    var $miFormUpdater;
    var $miFormEraser;
    
    
    
    
    
    
    function __construct() {
    
        $this->miParser=new PHPSQLParser();
        /*$this->$miFormCreator= new FormCreator();
        $this->$miFormRetriever=new FormRetriever();
        $this->$miFormUpdater=new FormUpdater();
        $this->$miFormDeleter=new FormEraser();;
        */
        
        
        
    }
    
    function create(){
        
        
        
    }
    
    function retrieve(){
    
    }
    
    function update(){
    
    }
       
    
    function delete(){
    
    }
    
    function parse($cadenaSql){
        
        $parsed=$this->miParser->parse($cadenaSql);
        
        var_dump($parsed);
        
        
    }
    
    
}