CREATE TABLE trabajosdegrado.ant_tcpto ( 
	cpto_cpto varchar(20) NOT NULL,    -- Identificador del concepto (MODIFICABLE, VIABLE, NO_VIABLE) 
	cpto_tipo varchar(20) NOT NULL,    -- Representa el tipo de concepto emitido por el revisor sobre el anteproyecto asociado (APROBATORIO, INTERMEDIO, NO_APROBATORIO) 
	cpto_descri varchar(2000) NOT NULL,    -- Almacena la descripción de cada concepto de revisiï¿½n de anteproyecto 
	cpto_instancia varchar(20) NOT NULL    -- Instancia que puede emitir el concepto de evaluación del anteproyecto 
)
;
COMMENT ON TABLE trabajosdegrado.ant_tcpto
    IS 'tabla que almacena los conceptos que pueden ser emitidos al evaluar un anteproyecto'
;
COMMENT ON COLUMN trabajosdegrado.ant_tcpto.cpto_cpto
    IS 'Identificador del concepto (MODIFICABLE, VIABLE, NO_VIABLE)'
;
COMMENT ON COLUMN trabajosdegrado.ant_tcpto.cpto_tipo
    IS 'Representa el tipo de concepto emitido por el revisor sobre el anteproyecto asociado (APROBATORIO, INTERMEDIO, NO_APROBATORIO)'
;
COMMENT ON COLUMN trabajosdegrado.ant_tcpto.cpto_descri
    IS 'Almacena la descripción de cada concepto de revisión de anteproyecto'
;
COMMENT ON COLUMN trabajosdegrado.ant_tcpto.cpto_instancia
    IS 'Instancia que puede emitir el concepto de evaluación del anteproyecto'
;

ALTER TABLE trabajosdegrado.ant_tcpto ADD CONSTRAINT pk_ant_tcpto 
	PRIMARY KEY (cpto_cpto)
;


ALTER TABLE trabajosdegrado.ant_tcpto ADD CONSTRAINT fk_ant_tcpto_ant_tinstancia 
	FOREIGN KEY (cpto_instancia) REFERENCES trabajosdegrado.ant_tinstancia (instancia_instancia)
;


Insert into trabajosdegrado.ant_tcpto (CPTO_CPTO,CPTO_TIPO,CPTO_DESCRI,CPTO_INSTANCIA) 
values ('VIABLE','APROBATORIO','El anteproyecto cumple con los requisitos mínimos de forma y fondo para la modalidad de trabajo de grado','REVISOR');

Insert into trabajosdegrado.ant_tcpto (CPTO_CPTO,CPTO_TIPO,CPTO_DESCRI,CPTO_INSTANCIA) 
values ('MODIFICABLE','INTERMEDIO','El anteproyecto no reune los requisitos de forma o fondo para su realización por tanto el estudiante deberá realizar ajustes al documento','REVISOR');

Insert into trabajosdegrado.ant_tcpto (CPTO_CPTO,CPTO_TIPO,CPTO_DESCRI,CPTO_INSTANCIA) 
values ('NO_VIABLE','NO_APROBATORIO','El anteproyecto no cumple de manera sustancial los requisitos de forma o fondo.  El estudiante deberá iniciar de nuevo el proceso','REVISOR');

Insert into trabajosdegrado.ant_tcpto (CPTO_CPTO,CPTO_TIPO,CPTO_DESCRI,CPTO_INSTANCIA) 
values ('MODIFICADO','INTERMEDIO','Es presentado una nueva versión del anteproyecto con los ajustes solicitados para que sea nuevamente revisado','ESTUDIANTE');


commit;
