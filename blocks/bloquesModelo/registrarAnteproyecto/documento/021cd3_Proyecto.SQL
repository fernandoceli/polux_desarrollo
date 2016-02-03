--
-- PostgreSQL database dump
--

-- Dumped from database version 9.4.4
-- Dumped by pg_dump version 9.4.4
-- Started on 2016-01-25 20:54:40

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = trabajosdegrado, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 255 (class 1259 OID 35981)
-- Name: pry_tacproy; Type: TABLE; Schema: trabajosdegrado; Owner: postgres; Tablespace: 
--

CREATE TABLE pry_tacproy (
    acproy_acono bigint NOT NULL,
    acproy_proy bigint NOT NULL
);


ALTER TABLE pry_tacproy OWNER TO postgres;

--
-- TOC entry 238 (class 1259 OID 27889)
-- Name: pry_tcpto; Type: TABLE; Schema: trabajosdegrado; Owner: postgres; Tablespace: 
--

CREATE TABLE pry_tcpto (
    cpto_cpto character varying(20) NOT NULL,
    cpto_tipo character varying(20) NOT NULL,
    cpto_descri character varying(2000) NOT NULL,
    cpto_instancia character varying(20) NOT NULL
);


ALTER TABLE pry_tcpto OWNER TO postgres;

--
-- TOC entry 2319 (class 0 OID 0)
-- Dependencies: 238
-- Name: TABLE pry_tcpto; Type: COMMENT; Schema: trabajosdegrado; Owner: postgres
--

COMMENT ON TABLE pry_tcpto IS 'tabla que almacena los conceptos que pueden ser emitidos al evaluar un proyecto de grado ';


--
-- TOC entry 239 (class 1259 OID 27895)
-- Name: pry_tdapy; Type: TABLE; Schema: trabajosdegrado; Owner: postgres; Tablespace: 
--

CREATE TABLE pry_tdapy (
    dapy_dapy bigint DEFAULT nextval('"PRY_SDAPRY"'::regclass) NOT NULL,
    dapy_proy bigint NOT NULL,
    dapy_tdapy character varying(20) NOT NULL,
    dapy_falm date NOT NULL,
    dapy_usua character varying(100) NOT NULL,
    dapy_url character varying(200) NOT NULL,
    dapy_hash character varying(2000) NOT NULL,
    dapy_bytes character varying(2000) NOT NULL,
    dapy_nombre character varying(2000) NOT NULL,
    dapy_extension character varying(2000) NOT NULL
);


ALTER TABLE pry_tdapy OWNER TO postgres;

--
-- TOC entry 2320 (class 0 OID 0)
-- Dependencies: 239
-- Name: TABLE pry_tdapy; Type: COMMENT; Schema: trabajosdegrado; Owner: postgres
--

COMMENT ON TABLE pry_tdapy IS 'Tabla que almacena la informacion de un documento anexo relacionandolo con un proyecto dentro del sistema';


--
-- TOC entry 240 (class 1259 OID 27907)
-- Name: pry_tdproy; Type: TABLE; Schema: trabajosdegrado; Owner: postgres; Tablespace: 
--

CREATE TABLE pry_tdproy (
    dproy_dproy bigint NOT NULL,
    dproy_vers bigint NOT NULL,
    dproy_observ character varying(2000) NOT NULL,
    dproy_falm date NOT NULL,
    dproy_usua character varying(100) NOT NULL,
    dproy_proy bigint NOT NULL,
    dproy_url character varying(200) NOT NULL,
    dproy_hash character varying(2000) NOT NULL,
    dproy_bytes character varying(2000) NOT NULL,
    dproy_nombre character varying(2000) NOT NULL,
    dproy_extension character varying(2000) NOT NULL
);


ALTER TABLE pry_tdproy OWNER TO postgres;

--
-- TOC entry 2321 (class 0 OID 0)
-- Dependencies: 240
-- Name: TABLE pry_tdproy; Type: COMMENT; Schema: trabajosdegrado; Owner: postgres
--

COMMENT ON TABLE pry_tdproy IS 'Tabla que almacena la informacion de un documento digital relacionandolo con un proyecto dentro del sistema
';


--
-- TOC entry 241 (class 1259 OID 27913)
-- Name: pry_tduracion; Type: TABLE; Schema: trabajosdegrado; Owner: postgres; Tablespace: 
--

CREATE TABLE pry_tduracion (
    duracion_duracion bigint NOT NULL,
    duracion_descri character varying(2000) NOT NULL
);


ALTER TABLE pry_tduracion OWNER TO postgres;

--
-- TOC entry 2322 (class 0 OID 0)
-- Dependencies: 241
-- Name: TABLE pry_tduracion; Type: COMMENT; Schema: trabajosdegrado; Owner: postgres
--

COMMENT ON TABLE pry_tduracion IS 'Duracion en meses de un proyecto de grado';


--
-- TOC entry 242 (class 1259 OID 27919)
-- Name: pry_teapmp; Type: TABLE; Schema: trabajosdegrado; Owner: postgres; Tablespace: 
--

CREATE TABLE pry_teapmp (
    eapmp_eapmp character varying(20) NOT NULL,
    eapmp_descri character varying(500) NOT NULL
);


ALTER TABLE pry_teapmp OWNER TO postgres;

--
-- TOC entry 2323 (class 0 OID 0)
-- Dependencies: 242
-- Name: TABLE pry_teapmp; Type: COMMENT; Schema: trabajosdegrado; Owner: postgres
--

COMMENT ON TABLE pry_teapmp IS 'Tabla que almacena los estados de las actividades programadas del modulo de  proyectos';


--
-- TOC entry 243 (class 1259 OID 27925)
-- Name: pry_teproy; Type: TABLE; Schema: trabajosdegrado; Owner: postgres; Tablespace: 
--

CREATE TABLE pry_teproy (
    eproy_eproy character varying(20) NOT NULL,
    eproy_descri character varying(500) NOT NULL
);


ALTER TABLE pry_teproy OWNER TO postgres;

--
-- TOC entry 2324 (class 0 OID 0)
-- Dependencies: 243
-- Name: TABLE pry_teproy; Type: COMMENT; Schema: trabajosdegrado; Owner: postgres
--

COMMENT ON TABLE pry_teproy IS 'Tabla donde se almacenan los estados de proyecto';


--
-- TOC entry 254 (class 1259 OID 35944)
-- Name: pry_testpry; Type: TABLE; Schema: trabajosdegrado; Owner: postgres; Tablespace: 
--

CREATE TABLE pry_testpry (
    estproy_estd character varying(20) NOT NULL,
    estproy_proy bigint NOT NULL
);


ALTER TABLE pry_testpry OWNER TO postgres;

--
-- TOC entry 244 (class 1259 OID 27934)
-- Name: pry_tform; Type: TABLE; Schema: trabajosdegrado; Owner: postgres; Tablespace: 
--

CREATE TABLE pry_tform (
    form_form bigint NOT NULL,
    form_nombre character varying(2000) NOT NULL
);


ALTER TABLE pry_tform OWNER TO postgres;

--
-- TOC entry 2325 (class 0 OID 0)
-- Dependencies: 244
-- Name: TABLE pry_tform; Type: COMMENT; Schema: trabajosdegrado; Owner: postgres
--

COMMENT ON TABLE pry_tform IS 'Tabla que almacena los diferentes Formatos establecidos (Formato de revisión, formato de modificación) para el proceso de evaluación creados para formalizar los cambios y correcciones a realizar sobre un documento de proyecto';


--
-- TOC entry 245 (class 1259 OID 27944)
-- Name: pry_tgrta; Type: TABLE; Schema: trabajosdegrado; Owner: postgres; Tablespace: 
--

CREATE TABLE pry_tgrta (
    grta_grta bigint NOT NULL,
    grta_nombre character varying(200) NOT NULL
);


ALTER TABLE pry_tgrta OWNER TO postgres;

--
-- TOC entry 2326 (class 0 OID 0)
-- Dependencies: 245
-- Name: TABLE pry_tgrta; Type: COMMENT; Schema: trabajosdegrado; Owner: postgres
--

COMMENT ON TABLE pry_tgrta IS 'Almacenamiento de los grupos de respuestas posibles para una pregunta creada (modulo proyecto)';


--
-- TOC entry 246 (class 1259 OID 27947)
-- Name: pry_thproy; Type: TABLE; Schema: trabajosdegrado; Owner: postgres; Tablespace: 
--

CREATE TABLE pry_thproy (
    hproy_proy bigint NOT NULL,
    hproy_eproy character varying(20) NOT NULL,
    hproy_fasig date NOT NULL,
    hproy_obser character varying(2000) NOT NULL,
    hproy_usua character varying(20) NOT NULL
);


ALTER TABLE pry_thproy OWNER TO postgres;

--
-- TOC entry 2327 (class 0 OID 0)
-- Dependencies: 246
-- Name: TABLE pry_thproy; Type: COMMENT; Schema: trabajosdegrado; Owner: postgres
--

COMMENT ON TABLE pry_thproy IS 'Tabla que almacena el historial de proyectos de grado registrados en el sistema con el estado en el que se encuentra cada uno de ellos';


--
-- TOC entry 247 (class 1259 OID 27953)
-- Name: pry_tinstancia; Type: TABLE; Schema: trabajosdegrado; Owner: postgres; Tablespace: 
--

CREATE TABLE pry_tinstancia (
    instancia_instancia character varying(20) NOT NULL,
    instancia_descri character varying(2000) NOT NULL
);


ALTER TABLE pry_tinstancia OWNER TO postgres;

--
-- TOC entry 2328 (class 0 OID 0)
-- Dependencies: 247
-- Name: TABLE pry_tinstancia; Type: COMMENT; Schema: trabajosdegrado; Owner: postgres
--

COMMENT ON TABLE pry_tinstancia IS 'Instancias donde se pueden encontrar un proceso de evaluación de proyecto';


--
-- TOC entry 248 (class 1259 OID 27962)
-- Name: pry_torta; Type: TABLE; Schema: trabajosdegrado; Owner: postgres; Tablespace: 
--

CREATE TABLE pry_torta (
    orta_orta bigint NOT NULL,
    orta_opcion character varying(20) NOT NULL
);


ALTER TABLE pry_torta OWNER TO postgres;

--
-- TOC entry 2329 (class 0 OID 0)
-- Dependencies: 248
-- Name: TABLE pry_torta; Type: COMMENT; Schema: trabajosdegrado; Owner: postgres
--

COMMENT ON TABLE pry_torta IS 'Tabla que almacena las diferentes opciones de respuesta de pregunta de selecciÃ³n posible para las preguntas de los formularios pertenecientes al modulo de proyecto';


--
-- TOC entry 249 (class 1259 OID 27974)
-- Name: pry_tproy; Type: TABLE; Schema: trabajosdegrado; Owner: postgres; Tablespace: 
--

CREATE TABLE pry_tproy (
    proy_proy bigint DEFAULT nextval('"PRY_SPRY"'::regclass) NOT NULL,
    proy_antp bigint NOT NULL,
    proy_moda bigint NOT NULL,
    proy_pcur bigint NOT NULL,
    proy_titu character varying(4000) NOT NULL,
    proy_fcrea date NOT NULL,
    proy_descri character varying(4000) NOT NULL,
    proy_obser character varying(4000) NOT NULL,
    proy_eproy character varying(20) NOT NULL,
    proy_duracion bigint NOT NULL,
    proy_dir_int character varying(30)
);


ALTER TABLE pry_tproy OWNER TO postgres;

--
-- TOC entry 2330 (class 0 OID 0)
-- Dependencies: 249
-- Name: TABLE pry_tproy; Type: COMMENT; Schema: trabajosdegrado; Owner: postgres
--

COMMENT ON TABLE pry_tproy IS 'Tabla de almacenamiento de los proyectos inscritos en el sistema';


--
-- TOC entry 250 (class 1259 OID 28007)
-- Name: pry_ttdapy; Type: TABLE; Schema: trabajosdegrado; Owner: postgres; Tablespace: 
--

CREATE TABLE pry_ttdapy (
    tdapy_tdapy character varying(20) NOT NULL,
    tdapy_descri character varying(500) NOT NULL
);


ALTER TABLE pry_ttdapy OWNER TO postgres;

--
-- TOC entry 2331 (class 0 OID 0)
-- Dependencies: 250
-- Name: TABLE pry_ttdapy; Type: COMMENT; Schema: trabajosdegrado; Owner: postgres
--

COMMENT ON TABLE pry_ttdapy IS 'Tabla de almacenamiento de los tipos de documentos anexos de proyecto';


--
-- TOC entry 2314 (class 0 OID 35981)
-- Dependencies: 255
-- Data for Name: pry_tacproy; Type: TABLE DATA; Schema: trabajosdegrado; Owner: postgres
--

INSERT INTO pry_tacproy (acproy_acono, acproy_proy) VALUES (1113, 14);
INSERT INTO pry_tacproy (acproy_acono, acproy_proy) VALUES (1113, 15);
INSERT INTO pry_tacproy (acproy_acono, acproy_proy) VALUES (1113, 16);
INSERT INTO pry_tacproy (acproy_acono, acproy_proy) VALUES (1113, 17);
INSERT INTO pry_tacproy (acproy_acono, acproy_proy) VALUES (1113, 18);
INSERT INTO pry_tacproy (acproy_acono, acproy_proy) VALUES (1113, 19);
INSERT INTO pry_tacproy (acproy_acono, acproy_proy) VALUES (1113, 20);
INSERT INTO pry_tacproy (acproy_acono, acproy_proy) VALUES (1113, 21);
INSERT INTO pry_tacproy (acproy_acono, acproy_proy) VALUES (1113, 22);
INSERT INTO pry_tacproy (acproy_acono, acproy_proy) VALUES (1113, 23);
INSERT INTO pry_tacproy (acproy_acono, acproy_proy) VALUES (1113, 24);
INSERT INTO pry_tacproy (acproy_acono, acproy_proy) VALUES (1113, 25);


--
-- TOC entry 2300 (class 0 OID 27889)
-- Dependencies: 238
-- Data for Name: pry_tcpto; Type: TABLE DATA; Schema: trabajosdegrado; Owner: postgres
--

INSERT INTO pry_tcpto (cpto_cpto, cpto_tipo, cpto_descri, cpto_instancia) VALUES ('APROBADO', 'APROBATORIO', 'El documento de proyecto cumple con los requisitos mínimos de forma y fondo para su presentación como informe final de trabajo de grado', 'DIRECTOR');
INSERT INTO pry_tcpto (cpto_cpto, cpto_tipo, cpto_descri, cpto_instancia) VALUES ('MODIFICABLE', 'INTERMEDIO', 'El documento de proyecto no reune los requisitos de forma o fondo para su presentación como informe final por tanto el estudiante deberá realizarle ajustes', 'DIRECTOR');
INSERT INTO pry_tcpto (cpto_cpto, cpto_tipo, cpto_descri, cpto_instancia) VALUES ('REPROBADO', 'NO_APROBATORIO', 'El documento de proyecto no cumple de manera sustancial los requisitos de forma o fondo.  El estudiante deberá iniciar de nuevo el proceso', 'DIRECTOR');
INSERT INTO pry_tcpto (cpto_cpto, cpto_tipo, cpto_descri, cpto_instancia) VALUES ('MODIFICADO', 'INTERMEDIO', 'Es presentado una nueva versión del documento de proyecto con los ajustes solicitados para que sea nuevamente revisado', 'ESTUDIANTE');


--
-- TOC entry 2301 (class 0 OID 27895)
-- Dependencies: 239
-- Data for Name: pry_tdapy; Type: TABLE DATA; Schema: trabajosdegrado; Owner: postgres
--

INSERT INTO pry_tdapy (dapy_dapy, dapy_proy, dapy_tdapy, dapy_falm, dapy_usua, dapy_url, dapy_hash, dapy_bytes, dapy_nombre, dapy_extension) VALUES (7, 14, 'ACTA', '2016-01-25', '6666', 'http://localhost/polux_desarrollo/blocks/bloquesModelo/iniciarProyecto/documento/2fc472__004_charmander_by_theblacksavior-d63wei4.jpg', 'funcion hash', '53376', '_004_charmander_by_theblacksavior-d63wei4.jpg', 'image/jpeg');
INSERT INTO pry_tdapy (dapy_dapy, dapy_proy, dapy_tdapy, dapy_falm, dapy_usua, dapy_url, dapy_hash, dapy_bytes, dapy_nombre, dapy_extension) VALUES (8, 15, 'ACTA', '2016-01-25', '6666', 'http://localhost/polux_desarrollo/blocks/bloquesModelo/iniciarProyecto/documento/f2299c_10422529_867711506605904_8228874715144558907_n.jpg', 'funcion hash', '214384', '10422529_867711506605904_8228874715144558907_n.jpg', 'image/jpeg');
INSERT INTO pry_tdapy (dapy_dapy, dapy_proy, dapy_tdapy, dapy_falm, dapy_usua, dapy_url, dapy_hash, dapy_bytes, dapy_nombre, dapy_extension) VALUES (9, 16, 'ACTA', '2016-01-25', '6666', 'http://localhost/polux_desarrollo/blocks/bloquesModelo/iniciarProyecto/documento/c6bc67_10422529_867711506605904_8228874715144558907_n.jpg', 'funcion hash', '214384', '10422529_867711506605904_8228874715144558907_n.jpg', 'image/jpeg');
INSERT INTO pry_tdapy (dapy_dapy, dapy_proy, dapy_tdapy, dapy_falm, dapy_usua, dapy_url, dapy_hash, dapy_bytes, dapy_nombre, dapy_extension) VALUES (10, 17, 'ACTA', '2016-01-25', '6666', 'http://localhost/polux_desarrollo/blocks/bloquesModelo/iniciarProyecto/documento/d2a50b__004_charmander_by_theblacksavior-d63wei4.jpg', 'funcion hash', '53376', '_004_charmander_by_theblacksavior-d63wei4.jpg', 'image/jpeg');
INSERT INTO pry_tdapy (dapy_dapy, dapy_proy, dapy_tdapy, dapy_falm, dapy_usua, dapy_url, dapy_hash, dapy_bytes, dapy_nombre, dapy_extension) VALUES (11, 18, 'ACTA', '2016-01-25', '6666', 'http://localhost/polux_desarrollo/blocks/bloquesModelo/iniciarProyecto/documento/848e78_1375682_757668514293625_5704222119859226793_n.jpg', 'funcion hash', '19387', '1375682_757668514293625_5704222119859226793_n.jpg', 'image/jpeg');
INSERT INTO pry_tdapy (dapy_dapy, dapy_proy, dapy_tdapy, dapy_falm, dapy_usua, dapy_url, dapy_hash, dapy_bytes, dapy_nombre, dapy_extension) VALUES (12, 19, 'ACTA', '2016-01-25', '6666', 'http://localhost/polux_desarrollo/blocks/bloquesModelo/iniciarProyecto/documento/ab82f4_10422529_867711506605904_8228874715144558907_n.jpg', 'funcion hash', '214384', '10422529_867711506605904_8228874715144558907_n.jpg', 'image/jpeg');
INSERT INTO pry_tdapy (dapy_dapy, dapy_proy, dapy_tdapy, dapy_falm, dapy_usua, dapy_url, dapy_hash, dapy_bytes, dapy_nombre, dapy_extension) VALUES (13, 20, 'ACTA', '2016-01-25', '6666', 'http://localhost/polux_desarrollo/blocks/bloquesModelo/iniciarProyecto/documento/da8caa_10422529_867711506605904_8228874715144558907_n.jpg', 'funcion hash', '214384', '10422529_867711506605904_8228874715144558907_n.jpg', 'image/jpeg');
INSERT INTO pry_tdapy (dapy_dapy, dapy_proy, dapy_tdapy, dapy_falm, dapy_usua, dapy_url, dapy_hash, dapy_bytes, dapy_nombre, dapy_extension) VALUES (14, 21, 'ACTA', '2016-01-25', '6666', 'http://localhost/polux_desarrollo/blocks/bloquesModelo/iniciarProyecto/documento/7e440d_10422529_867711506605904_8228874715144558907_n.jpg', 'funcion hash', '214384', '10422529_867711506605904_8228874715144558907_n.jpg', 'image/jpeg');
INSERT INTO pry_tdapy (dapy_dapy, dapy_proy, dapy_tdapy, dapy_falm, dapy_usua, dapy_url, dapy_hash, dapy_bytes, dapy_nombre, dapy_extension) VALUES (15, 22, 'ACTA', '2016-01-25', '6666', 'http://localhost/polux_desarrollo/blocks/bloquesModelo/iniciarProyecto/documento/ebdf0e_10422529_867711506605904_8228874715144558907_n.jpg', 'funcion hash', '214384', '10422529_867711506605904_8228874715144558907_n.jpg', 'image/jpeg');
INSERT INTO pry_tdapy (dapy_dapy, dapy_proy, dapy_tdapy, dapy_falm, dapy_usua, dapy_url, dapy_hash, dapy_bytes, dapy_nombre, dapy_extension) VALUES (16, 23, 'ACTA', '2016-01-25', '6666', 'http://localhost/polux_desarrollo/blocks/bloquesModelo/iniciarProyecto/documento/bd4c6e_10422529_867711506605904_8228874715144558907_n.jpg', 'funcion hash', '214384', '10422529_867711506605904_8228874715144558907_n.jpg', 'image/jpeg');
INSERT INTO pry_tdapy (dapy_dapy, dapy_proy, dapy_tdapy, dapy_falm, dapy_usua, dapy_url, dapy_hash, dapy_bytes, dapy_nombre, dapy_extension) VALUES (17, 24, 'ACTA', '2016-01-25', '6666', 'http://localhost/polux_desarrollo/blocks/bloquesModelo/iniciarProyecto/documento/1abc5f_10422529_867711506605904_8228874715144558907_n.jpg', 'funcion hash', '214384', '10422529_867711506605904_8228874715144558907_n.jpg', 'image/jpeg');
INSERT INTO pry_tdapy (dapy_dapy, dapy_proy, dapy_tdapy, dapy_falm, dapy_usua, dapy_url, dapy_hash, dapy_bytes, dapy_nombre, dapy_extension) VALUES (18, 25, 'ACTA', '2016-01-25', '6666', 'http://localhost/polux_desarrollo/blocks/bloquesModelo/iniciarProyecto/documento/80323d_1090938_1524405794464343_6465976755922498659_o.jpg', 'funcion hash', '77385', '1090938_1524405794464343_6465976755922498659_o.jpg', 'image/jpeg');


--
-- TOC entry 2302 (class 0 OID 27907)
-- Dependencies: 240
-- Data for Name: pry_tdproy; Type: TABLE DATA; Schema: trabajosdegrado; Owner: postgres
--



--
-- TOC entry 2303 (class 0 OID 27913)
-- Dependencies: 241
-- Data for Name: pry_tduracion; Type: TABLE DATA; Schema: trabajosdegrado; Owner: postgres
--

INSERT INTO pry_tduracion (duracion_duracion, duracion_descri) VALUES (6, ' 6 meses');
INSERT INTO pry_tduracion (duracion_duracion, duracion_descri) VALUES (12, ' 1 año');
INSERT INTO pry_tduracion (duracion_duracion, duracion_descri) VALUES (18, ' 1 año y 6 meses');
INSERT INTO pry_tduracion (duracion_duracion, duracion_descri) VALUES (24, ' 2 años');


--
-- TOC entry 2304 (class 0 OID 27919)
-- Dependencies: 242
-- Data for Name: pry_teapmp; Type: TABLE DATA; Schema: trabajosdegrado; Owner: postgres
--

INSERT INTO pry_teapmp (eapmp_eapmp, eapmp_descri) VALUES ('PENDIENTE', 'Estado en que la actividad sobrepasa la fecha de inicio de actividad y se establece como pendiente');
INSERT INTO pry_teapmp (eapmp_eapmp, eapmp_descri) VALUES ('PROGRAMADA', 'Estado en que la actividad aun no sobrepasa la fecha de inicio de actividad');
INSERT INTO pry_teapmp (eapmp_eapmp, eapmp_descri) VALUES ('FINALIZADA', 'Estado en que la actvidad se señala como finalizada');


--
-- TOC entry 2305 (class 0 OID 27925)
-- Dependencies: 243
-- Data for Name: pry_teproy; Type: TABLE DATA; Schema: trabajosdegrado; Owner: postgres
--

INSERT INTO pry_teproy (eproy_eproy, eproy_descri) VALUES ('EN DESARROLLO', 'Estado inicial del proyecto');
INSERT INTO pry_teproy (eproy_eproy, eproy_descri) VALUES ('FINALIZADO', 'Estado que permite identificar que el proyecto ya ha sido finalizado en buen termino como proyecto de grado');
INSERT INTO pry_teproy (eproy_eproy, eproy_descri) VALUES ('INFORME FINAL', 'Estado que permite identificar que el documento de proyecto fue radicado como informe final');
INSERT INTO pry_teproy (eproy_eproy, eproy_descri) VALUES ('REPROBADO', 'Estado que permite indentificar que el proyecto fue reprobado por el Director Interno');
INSERT INTO pry_teproy (eproy_eproy, eproy_descri) VALUES ('CANCELADO', 'Estado que permite indentificar que el proyecto fue cancelado en esta etapa o alguna futura');


--
-- TOC entry 2313 (class 0 OID 35944)
-- Dependencies: 254
-- Data for Name: pry_testpry; Type: TABLE DATA; Schema: trabajosdegrado; Owner: postgres
--

INSERT INTO pry_testpry (estproy_estd, estproy_proy) VALUES ('20151020035', 14);
INSERT INTO pry_testpry (estproy_estd, estproy_proy) VALUES ('20151020035', 15);
INSERT INTO pry_testpry (estproy_estd, estproy_proy) VALUES ('20151020035', 16);
INSERT INTO pry_testpry (estproy_estd, estproy_proy) VALUES ('20151020035', 17);
INSERT INTO pry_testpry (estproy_estd, estproy_proy) VALUES ('20151020035', 18);
INSERT INTO pry_testpry (estproy_estd, estproy_proy) VALUES ('20151020035', 19);
INSERT INTO pry_testpry (estproy_estd, estproy_proy) VALUES ('20151020035', 20);
INSERT INTO pry_testpry (estproy_estd, estproy_proy) VALUES ('20151020035', 21);
INSERT INTO pry_testpry (estproy_estd, estproy_proy) VALUES ('20151020035', 22);
INSERT INTO pry_testpry (estproy_estd, estproy_proy) VALUES ('20151020035', 23);
INSERT INTO pry_testpry (estproy_estd, estproy_proy) VALUES ('20151020035', 24);
INSERT INTO pry_testpry (estproy_estd, estproy_proy) VALUES ('20151020035', 25);


--
-- TOC entry 2306 (class 0 OID 27934)
-- Dependencies: 244
-- Data for Name: pry_tform; Type: TABLE DATA; Schema: trabajosdegrado; Owner: postgres
--

INSERT INTO pry_tform (form_form, form_nombre) VALUES (1, 'Formato de revisión de docummento de proyecto');
INSERT INTO pry_tform (form_form, form_nombre) VALUES (2, 'Formato de modificación de documento de proyecto');


--
-- TOC entry 2307 (class 0 OID 27944)
-- Dependencies: 245
-- Data for Name: pry_tgrta; Type: TABLE DATA; Schema: trabajosdegrado; Owner: postgres
--

INSERT INTO pry_tgrta (grta_grta, grta_nombre) VALUES (1, 'SI-NO');
INSERT INTO pry_tgrta (grta_grta, grta_nombre) VALUES (2, 'BUENO-REGULAR-MALO');
INSERT INTO pry_tgrta (grta_grta, grta_nombre) VALUES (3, 'ABIERTA');


--
-- TOC entry 2308 (class 0 OID 27947)
-- Dependencies: 246
-- Data for Name: pry_thproy; Type: TABLE DATA; Schema: trabajosdegrado; Owner: postgres
--

INSERT INTO pry_thproy (hproy_proy, hproy_eproy, hproy_fasig, hproy_obser, hproy_usua) VALUES (14, 'EN DESARROLLO', '2016-01-25', 'cvyi', '6666');
INSERT INTO pry_thproy (hproy_proy, hproy_eproy, hproy_fasig, hproy_obser, hproy_usua) VALUES (15, 'EN DESARROLLO', '2016-01-25', 'sdfsd', '6666');
INSERT INTO pry_thproy (hproy_proy, hproy_eproy, hproy_fasig, hproy_obser, hproy_usua) VALUES (16, 'EN DESARROLLO', '2016-01-25', 'sdfsd', '6666');
INSERT INTO pry_thproy (hproy_proy, hproy_eproy, hproy_fasig, hproy_obser, hproy_usua) VALUES (17, 'EN DESARROLLO', '2016-01-25', 'sdfsd', '6666');
INSERT INTO pry_thproy (hproy_proy, hproy_eproy, hproy_fasig, hproy_obser, hproy_usua) VALUES (18, 'EN DESARROLLO', '2016-01-25', 'dfg', '6666');
INSERT INTO pry_thproy (hproy_proy, hproy_eproy, hproy_fasig, hproy_obser, hproy_usua) VALUES (19, 'EN DESARROLLO', '2016-01-25', 'sdfs', '6666');
INSERT INTO pry_thproy (hproy_proy, hproy_eproy, hproy_fasig, hproy_obser, hproy_usua) VALUES (20, 'EN DESARROLLO', '2016-01-25', 'sdfs', '6666');
INSERT INTO pry_thproy (hproy_proy, hproy_eproy, hproy_fasig, hproy_obser, hproy_usua) VALUES (21, 'EN DESARROLLO', '2016-01-25', 'sdfs', '6666');
INSERT INTO pry_thproy (hproy_proy, hproy_eproy, hproy_fasig, hproy_obser, hproy_usua) VALUES (22, 'EN DESARROLLO', '2016-01-25', 'sdfs', '6666');
INSERT INTO pry_thproy (hproy_proy, hproy_eproy, hproy_fasig, hproy_obser, hproy_usua) VALUES (23, 'EN DESARROLLO', '2016-01-25', 'sdfs', '6666');
INSERT INTO pry_thproy (hproy_proy, hproy_eproy, hproy_fasig, hproy_obser, hproy_usua) VALUES (24, 'EN DESARROLLO', '2016-01-25', 'sdfs', '6666');
INSERT INTO pry_thproy (hproy_proy, hproy_eproy, hproy_fasig, hproy_obser, hproy_usua) VALUES (25, 'EN DESARROLLO', '2016-01-25', 'sdf', '6666');


--
-- TOC entry 2309 (class 0 OID 27953)
-- Dependencies: 247
-- Data for Name: pry_tinstancia; Type: TABLE DATA; Schema: trabajosdegrado; Owner: postgres
--

INSERT INTO pry_tinstancia (instancia_instancia, instancia_descri) VALUES ('ESTUDIANTE', 'Son los autores o estudiantes a quienes les corresponde realizar la proxima acción en el proceso de evaluación de proyecto');
INSERT INTO pry_tinstancia (instancia_instancia, instancia_descri) VALUES ('DIRECTOR', 'Es el o los Director(es) Interno(s) a quien le corresponde realizar la proxima acción en el proceso de evaluación de proyecto');


--
-- TOC entry 2310 (class 0 OID 27962)
-- Dependencies: 248
-- Data for Name: pry_torta; Type: TABLE DATA; Schema: trabajosdegrado; Owner: postgres
--

INSERT INTO pry_torta (orta_orta, orta_opcion) VALUES (1, 'SI');
INSERT INTO pry_torta (orta_orta, orta_opcion) VALUES (2, 'NO');
INSERT INTO pry_torta (orta_orta, orta_opcion) VALUES (3, 'NO APLICA');
INSERT INTO pry_torta (orta_orta, orta_opcion) VALUES (4, 'BUENO');
INSERT INTO pry_torta (orta_orta, orta_opcion) VALUES (5, 'REGULAR');
INSERT INTO pry_torta (orta_orta, orta_opcion) VALUES (6, 'MALO');


--
-- TOC entry 2311 (class 0 OID 27974)
-- Dependencies: 249
-- Data for Name: pry_tproy; Type: TABLE DATA; Schema: trabajosdegrado; Owner: postgres
--

INSERT INTO pry_tproy (proy_proy, proy_antp, proy_moda, proy_pcur, proy_titu, proy_fcrea, proy_descri, proy_obser, proy_eproy, proy_duracion, proy_dir_int) VALUES (14, 84, 1, 20, 'tiu', '2016-01-25', 'des', 'cvyi', 'EN DESARROLLO', 6, '321478569');
INSERT INTO pry_tproy (proy_proy, proy_antp, proy_moda, proy_pcur, proy_titu, proy_fcrea, proy_descri, proy_obser, proy_eproy, proy_duracion, proy_dir_int) VALUES (15, 84, 1, 20, 'sdfsd', '2016-01-25', 'sdfs', 'sdfsd', 'EN DESARROLLO', 6, '321478569');
INSERT INTO pry_tproy (proy_proy, proy_antp, proy_moda, proy_pcur, proy_titu, proy_fcrea, proy_descri, proy_obser, proy_eproy, proy_duracion, proy_dir_int) VALUES (19, 84, 1, 20, 'sdfdsf', '2016-01-25', 'sdfsf', 'sdfs', 'EN DESARROLLO', 6, '321478569');
INSERT INTO pry_tproy (proy_proy, proy_antp, proy_moda, proy_pcur, proy_titu, proy_fcrea, proy_descri, proy_obser, proy_eproy, proy_duracion, proy_dir_int) VALUES (22, 84, 1, 20, 'sdfdsf', '2016-01-25', 'sdfsf', 'sdfs', 'EN DESARROLLO', 6, '321478569');
INSERT INTO pry_tproy (proy_proy, proy_antp, proy_moda, proy_pcur, proy_titu, proy_fcrea, proy_descri, proy_obser, proy_eproy, proy_duracion, proy_dir_int) VALUES (18, 84, 1, 20, 'dfdsg', '2016-01-25', 'dfg', 'dfg', 'EN DESARROLLO', 6, '321478569');
INSERT INTO pry_tproy (proy_proy, proy_antp, proy_moda, proy_pcur, proy_titu, proy_fcrea, proy_descri, proy_obser, proy_eproy, proy_duracion, proy_dir_int) VALUES (24, 84, 1, 20, 'sdfdsf', '2016-01-25', 'sdfsf', 'sdfs', 'EN DESARROLLO', 6, '321478569');
INSERT INTO pry_tproy (proy_proy, proy_antp, proy_moda, proy_pcur, proy_titu, proy_fcrea, proy_descri, proy_obser, proy_eproy, proy_duracion, proy_dir_int) VALUES (21, 84, 1, 20, 'sdfdsf', '2016-01-25', 'sdfsf', 'sdfs', 'EN DESARROLLO', 6, '321478569');
INSERT INTO pry_tproy (proy_proy, proy_antp, proy_moda, proy_pcur, proy_titu, proy_fcrea, proy_descri, proy_obser, proy_eproy, proy_duracion, proy_dir_int) VALUES (16, 84, 1, 20, 'sdfsd', '2016-01-25', 'sdfs', 'sdfsd', 'EN DESARROLLO', 6, '321478569');
INSERT INTO pry_tproy (proy_proy, proy_antp, proy_moda, proy_pcur, proy_titu, proy_fcrea, proy_descri, proy_obser, proy_eproy, proy_duracion, proy_dir_int) VALUES (25, 84, 1, 20, 'fdsf', '2016-01-25', 'sdfds', 'sdf', 'EN DESARROLLO', 6, '321478569');
INSERT INTO pry_tproy (proy_proy, proy_antp, proy_moda, proy_pcur, proy_titu, proy_fcrea, proy_descri, proy_obser, proy_eproy, proy_duracion, proy_dir_int) VALUES (23, 84, 1, 20, 'sdfdsf', '2016-01-25', 'sdfsf', 'sdfs', 'EN DESARROLLO', 6, '321478569');
INSERT INTO pry_tproy (proy_proy, proy_antp, proy_moda, proy_pcur, proy_titu, proy_fcrea, proy_descri, proy_obser, proy_eproy, proy_duracion, proy_dir_int) VALUES (20, 84, 1, 20, 'sdfdsf', '2016-01-25', 'sdfsf', 'sdfs', 'EN DESARROLLO', 6, '321478569');
INSERT INTO pry_tproy (proy_proy, proy_antp, proy_moda, proy_pcur, proy_titu, proy_fcrea, proy_descri, proy_obser, proy_eproy, proy_duracion, proy_dir_int) VALUES (17, 84, 1, 20, 'sdfsdf', '2016-01-25', 'sdfsdf', 'sdfsd', 'EN DESARROLLO', 6, '321478569');


--
-- TOC entry 2312 (class 0 OID 28007)
-- Dependencies: 250
-- Data for Name: pry_ttdapy; Type: TABLE DATA; Schema: trabajosdegrado; Owner: postgres
--

INSERT INTO pry_ttdapy (tdapy_tdapy, tdapy_descri) VALUES ('ACTA', 'Acta de concejo donde se puede iniciar proyecto');


--
-- TOC entry 2144 (class 2606 OID 28028)
-- Name: pk_pry_tcpto; Type: CONSTRAINT; Schema: trabajosdegrado; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY pry_tcpto
    ADD CONSTRAINT pk_pry_tcpto PRIMARY KEY (cpto_cpto);


--
-- TOC entry 2146 (class 2606 OID 28030)
-- Name: pk_pry_tdapy; Type: CONSTRAINT; Schema: trabajosdegrado; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY pry_tdapy
    ADD CONSTRAINT pk_pry_tdapy PRIMARY KEY (dapy_dapy);


--
-- TOC entry 2148 (class 2606 OID 28034)
-- Name: pk_pry_tdproy; Type: CONSTRAINT; Schema: trabajosdegrado; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY pry_tdproy
    ADD CONSTRAINT pk_pry_tdproy PRIMARY KEY (dproy_dproy);


--
-- TOC entry 2153 (class 2606 OID 28036)
-- Name: pk_pry_tduracion; Type: CONSTRAINT; Schema: trabajosdegrado; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY pry_tduracion
    ADD CONSTRAINT pk_pry_tduracion PRIMARY KEY (duracion_duracion);


--
-- TOC entry 2155 (class 2606 OID 28038)
-- Name: pk_pry_teapmp; Type: CONSTRAINT; Schema: trabajosdegrado; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY pry_teapmp
    ADD CONSTRAINT pk_pry_teapmp PRIMARY KEY (eapmp_eapmp);


--
-- TOC entry 2157 (class 2606 OID 28040)
-- Name: pk_pry_teproy; Type: CONSTRAINT; Schema: trabajosdegrado; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY pry_teproy
    ADD CONSTRAINT pk_pry_teproy PRIMARY KEY (eproy_eproy);


--
-- TOC entry 2159 (class 2606 OID 28044)
-- Name: pk_pry_tform; Type: CONSTRAINT; Schema: trabajosdegrado; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY pry_tform
    ADD CONSTRAINT pk_pry_tform PRIMARY KEY (form_form);


--
-- TOC entry 2161 (class 2606 OID 28048)
-- Name: pk_pry_tgrta; Type: CONSTRAINT; Schema: trabajosdegrado; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY pry_tgrta
    ADD CONSTRAINT pk_pry_tgrta PRIMARY KEY (grta_grta);


--
-- TOC entry 2163 (class 2606 OID 28050)
-- Name: pk_pry_thproy; Type: CONSTRAINT; Schema: trabajosdegrado; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY pry_thproy
    ADD CONSTRAINT pk_pry_thproy PRIMARY KEY (hproy_proy, hproy_eproy, hproy_fasig, hproy_usua);


--
-- TOC entry 2165 (class 2606 OID 28052)
-- Name: pk_pry_tinstancia; Type: CONSTRAINT; Schema: trabajosdegrado; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY pry_tinstancia
    ADD CONSTRAINT pk_pry_tinstancia PRIMARY KEY (instancia_instancia);


--
-- TOC entry 2167 (class 2606 OID 28056)
-- Name: pk_pry_torta; Type: CONSTRAINT; Schema: trabajosdegrado; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY pry_torta
    ADD CONSTRAINT pk_pry_torta PRIMARY KEY (orta_orta);


--
-- TOC entry 2169 (class 2606 OID 28062)
-- Name: pk_pry_tproy; Type: CONSTRAINT; Schema: trabajosdegrado; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY pry_tproy
    ADD CONSTRAINT pk_pry_tproy PRIMARY KEY (proy_proy);


--
-- TOC entry 2171 (class 2606 OID 28074)
-- Name: pk_pry_ttdapy; Type: CONSTRAINT; Schema: trabajosdegrado; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY pry_ttdapy
    ADD CONSTRAINT pk_pry_ttdapy PRIMARY KEY (tdapy_tdapy);


--
-- TOC entry 2175 (class 2606 OID 35985)
-- Name: pry_tacproy_pkey; Type: CONSTRAINT; Schema: trabajosdegrado; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY pry_tacproy
    ADD CONSTRAINT pry_tacproy_pkey PRIMARY KEY (acproy_acono, acproy_proy);


--
-- TOC entry 2173 (class 2606 OID 35950)
-- Name: pry_testpry_pkey; Type: CONSTRAINT; Schema: trabajosdegrado; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY pry_testpry
    ADD CONSTRAINT pry_testpry_pkey PRIMARY KEY (estproy_estd, estproy_proy);


--
-- TOC entry 2151 (class 2606 OID 28082)
-- Name: uq_pry_tdproy_dproy_dproy; Type: CONSTRAINT; Schema: trabajosdegrado; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY pry_tdproy
    ADD CONSTRAINT uq_pry_tdproy_dproy_dproy UNIQUE (dproy_dproy);


--
-- TOC entry 2149 (class 1259 OID 28083)
-- Name: uk_pry_tdproy; Type: INDEX; Schema: trabajosdegrado; Owner: postgres; Tablespace: 
--

CREATE UNIQUE INDEX uk_pry_tdproy ON pry_tdproy USING btree (dproy_vers, dproy_dproy);


--
-- TOC entry 2176 (class 2606 OID 28108)
-- Name: fk_pry_tcpto_pry_tinstancia; Type: FK CONSTRAINT; Schema: trabajosdegrado; Owner: postgres
--

ALTER TABLE ONLY pry_tcpto
    ADD CONSTRAINT fk_pry_tcpto_pry_tinstancia FOREIGN KEY (cpto_instancia) REFERENCES pry_tinstancia(instancia_instancia);


--
-- TOC entry 2177 (class 2606 OID 28113)
-- Name: fk_pry_tdapy_pry_tproy; Type: FK CONSTRAINT; Schema: trabajosdegrado; Owner: postgres
--

ALTER TABLE ONLY pry_tdapy
    ADD CONSTRAINT fk_pry_tdapy_pry_tproy FOREIGN KEY (dapy_proy) REFERENCES pry_tproy(proy_proy);


--
-- TOC entry 2178 (class 2606 OID 28118)
-- Name: fk_pry_tdapy_pry_ttdapy; Type: FK CONSTRAINT; Schema: trabajosdegrado; Owner: postgres
--

ALTER TABLE ONLY pry_tdapy
    ADD CONSTRAINT fk_pry_tdapy_pry_ttdapy FOREIGN KEY (dapy_tdapy) REFERENCES pry_ttdapy(tdapy_tdapy);


--
-- TOC entry 2179 (class 2606 OID 28133)
-- Name: fk_pry_tdproy_pry_tproy; Type: FK CONSTRAINT; Schema: trabajosdegrado; Owner: postgres
--

ALTER TABLE ONLY pry_tdproy
    ADD CONSTRAINT fk_pry_tdproy_pry_tproy FOREIGN KEY (dproy_proy) REFERENCES pry_tproy(proy_proy);


--
-- TOC entry 2180 (class 2606 OID 28173)
-- Name: fk_pry_thproy_pry_teproy; Type: FK CONSTRAINT; Schema: trabajosdegrado; Owner: postgres
--

ALTER TABLE ONLY pry_thproy
    ADD CONSTRAINT fk_pry_thproy_pry_teproy FOREIGN KEY (hproy_eproy) REFERENCES pry_teproy(eproy_eproy);


--
-- TOC entry 2181 (class 2606 OID 28178)
-- Name: fk_pry_thproy_pry_tproy; Type: FK CONSTRAINT; Schema: trabajosdegrado; Owner: postgres
--

ALTER TABLE ONLY pry_thproy
    ADD CONSTRAINT fk_pry_thproy_pry_tproy FOREIGN KEY (hproy_proy) REFERENCES pry_tproy(proy_proy);


--
-- TOC entry 2185 (class 2606 OID 28218)
-- Name: fk_pry_tproy_ant_tantp; Type: FK CONSTRAINT; Schema: trabajosdegrado; Owner: postgres
--

ALTER TABLE ONLY pry_tproy
    ADD CONSTRAINT fk_pry_tproy_ant_tantp FOREIGN KEY (proy_antp) REFERENCES ant_tantp(antp_antp);


--
-- TOC entry 2183 (class 2606 OID 28208)
-- Name: fk_pry_tproy_ge_tmoda; Type: FK CONSTRAINT; Schema: trabajosdegrado; Owner: postgres
--

ALTER TABLE ONLY pry_tproy
    ADD CONSTRAINT fk_pry_tproy_ge_tmoda FOREIGN KEY (proy_moda) REFERENCES ge_tmoda(moda_moda);


--
-- TOC entry 2184 (class 2606 OID 28213)
-- Name: fk_pry_tproy_ge_tpcur; Type: FK CONSTRAINT; Schema: trabajosdegrado; Owner: postgres
--

ALTER TABLE ONLY pry_tproy
    ADD CONSTRAINT fk_pry_tproy_ge_tpcur FOREIGN KEY (proy_pcur) REFERENCES ge_tpcur(pcur_pcur);


--
-- TOC entry 2186 (class 2606 OID 28253)
-- Name: fk_pry_tproy_pry_tduracion; Type: FK CONSTRAINT; Schema: trabajosdegrado; Owner: postgres
--

ALTER TABLE ONLY pry_tproy
    ADD CONSTRAINT fk_pry_tproy_pry_tduracion FOREIGN KEY (proy_duracion) REFERENCES pry_tduracion(duracion_duracion);


--
-- TOC entry 2182 (class 2606 OID 28203)
-- Name: fk_pry_tproy_pry_teproy; Type: FK CONSTRAINT; Schema: trabajosdegrado; Owner: postgres
--

ALTER TABLE ONLY pry_tproy
    ADD CONSTRAINT fk_pry_tproy_pry_teproy FOREIGN KEY (proy_eproy) REFERENCES pry_teproy(eproy_eproy);


--
-- TOC entry 2189 (class 2606 OID 35986)
-- Name: pry_tacproy_acproy_acono_fkey; Type: FK CONSTRAINT; Schema: trabajosdegrado; Owner: postgres
--

ALTER TABLE ONLY pry_tacproy
    ADD CONSTRAINT pry_tacproy_acproy_acono_fkey FOREIGN KEY (acproy_acono) REFERENCES ge_tacono(acono_acono);


--
-- TOC entry 2190 (class 2606 OID 35991)
-- Name: pry_tacproy_acproy_proy_fkey; Type: FK CONSTRAINT; Schema: trabajosdegrado; Owner: postgres
--

ALTER TABLE ONLY pry_tacproy
    ADD CONSTRAINT pry_tacproy_acproy_proy_fkey FOREIGN KEY (acproy_proy) REFERENCES pry_tproy(proy_proy);


--
-- TOC entry 2187 (class 2606 OID 35961)
-- Name: pry_testpry_estproy_estd_fkey; Type: FK CONSTRAINT; Schema: trabajosdegrado; Owner: postgres
--

ALTER TABLE ONLY pry_testpry
    ADD CONSTRAINT pry_testpry_estproy_estd_fkey FOREIGN KEY (estproy_estd) REFERENCES ge_testd(estd_estd);


--
-- TOC entry 2188 (class 2606 OID 35966)
-- Name: pry_testpry_estproy_proy_fkey; Type: FK CONSTRAINT; Schema: trabajosdegrado; Owner: postgres
--

ALTER TABLE ONLY pry_testpry
    ADD CONSTRAINT pry_testpry_estproy_proy_fkey FOREIGN KEY (estproy_proy) REFERENCES pry_tproy(proy_proy);


-- Completed on 2016-01-25 20:54:42

--
-- PostgreSQL database dump complete
--

