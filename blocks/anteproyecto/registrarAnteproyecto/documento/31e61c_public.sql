--
-- PostgreSQL database dump
--

-- Dumped from database version 9.2.4
-- Dumped by pg_dump version 9.3.9
-- Started on 2016-03-30 10:43:06

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- TOC entry 7 (class 2615 OID 133895)
-- Name: general; Type: SCHEMA; Schema: -; Owner: usuariourano
--

CREATE SCHEMA general;


ALTER SCHEMA general OWNER TO usuariourano;

--
-- TOC entry 208 (class 3079 OID 12595)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 3055 (class 0 OID 0)
-- Dependencies: 208
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = general, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 189 (class 1259 OID 135865)
-- Name: est_noti; Type: TABLE; Schema: general; Owner: usuariourano; Tablespace: 
--

CREATE TABLE est_noti (
    id_estado bigint NOT NULL,
    nombre_estado character(50)
);


ALTER TABLE general.est_noti OWNER TO usuariourano;

--
-- TOC entry 3056 (class 0 OID 0)
-- Dependencies: 189
-- Name: COLUMN est_noti.id_estado; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON COLUMN est_noti.id_estado IS 'Identificador del estado';


--
-- TOC entry 3057 (class 0 OID 0)
-- Dependencies: 189
-- Name: COLUMN est_noti.nombre_estado; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON COLUMN est_noti.nombre_estado IS 'Nombre del estado';


--
-- TOC entry 190 (class 1259 OID 135875)
-- Name: est_notifi; Type: TABLE; Schema: general; Owner: usuariourano; Tablespace: 
--

CREATE TABLE est_notifi (
    id_estado bigint NOT NULL,
    nombre_estado character(50)
);


ALTER TABLE general.est_notifi OWNER TO usuariourano;

--
-- TOC entry 3058 (class 0 OID 0)
-- Dependencies: 190
-- Name: TABLE est_notifi; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON TABLE est_notifi IS 'Tabla de los posibles estados de las notificaciones';


--
-- TOC entry 3059 (class 0 OID 0)
-- Dependencies: 190
-- Name: COLUMN est_notifi.id_estado; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON COLUMN est_notifi.id_estado IS 'Identificador del estado de la notificacion';


--
-- TOC entry 3060 (class 0 OID 0)
-- Dependencies: 190
-- Name: COLUMN est_notifi.nombre_estado; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON COLUMN est_notifi.nombre_estado IS 'Nombre de la notificacion';


--
-- TOC entry 191 (class 1259 OID 135925)
-- Name: id_noticia_seq; Type: SEQUENCE; Schema: general; Owner: usuariourano
--

CREATE SEQUENCE id_noticia_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999999999999
    CACHE 1;


ALTER TABLE general.id_noticia_seq OWNER TO usuariourano;

--
-- TOC entry 192 (class 1259 OID 135929)
-- Name: id_notificacion_seq; Type: SEQUENCE; Schema: general; Owner: usuariourano
--

CREATE SEQUENCE id_notificacion_seq
    START WITH 17
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999999999999
    CACHE 1;


ALTER TABLE general.id_notificacion_seq OWNER TO usuariourano;

--
-- TOC entry 193 (class 1259 OID 135933)
-- Name: id_tipo_noticia_seq; Type: SEQUENCE; Schema: general; Owner: usuariourano
--

CREATE SEQUENCE id_tipo_noticia_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999999999999
    CACHE 1;


ALTER TABLE general.id_tipo_noticia_seq OWNER TO usuariourano;

--
-- TOC entry 194 (class 1259 OID 135935)
-- Name: id_tipo_notifi_seq; Type: SEQUENCE; Schema: general; Owner: usuariourano
--

CREATE SEQUENCE id_tipo_notifi_seq
    START WITH 5
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999999999999
    CACHE 1;


ALTER TABLE general.id_tipo_notifi_seq OWNER TO usuariourano;

--
-- TOC entry 197 (class 1259 OID 135996)
-- Name: noticia; Type: TABLE; Schema: general; Owner: usuariourano; Tablespace: 
--

CREATE TABLE noticia (
    id_noticia bigint DEFAULT nextval(('general."id_noticia_seq"'::text)::regclass) NOT NULL,
    noti_nombre character(100) NOT NULL,
    noti_descripcion character(1000),
    noti_enlace character(100),
    noti_tipo bigint NOT NULL,
    noti_finicio date NOT NULL,
    noti_ffin date NOT NULL,
    noti_estado integer DEFAULT 1 NOT NULL,
    noti_anio integer,
    noti_periodo integer,
    noti_fradicacion timestamp without time zone,
    noti_usr_remi character(50),
    noti_img_usr_enlace character(1000)
);


ALTER TABLE general.noticia OWNER TO usuariourano;

--
-- TOC entry 3061 (class 0 OID 0)
-- Dependencies: 197
-- Name: TABLE noticia; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON TABLE noticia IS 'Tabla que almacena la informacion de las noticias a presentar al usuario';


--
-- TOC entry 3062 (class 0 OID 0)
-- Dependencies: 197
-- Name: COLUMN noticia.id_noticia; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON COLUMN noticia.id_noticia IS 'Identificador unico de las noticias';


--
-- TOC entry 3063 (class 0 OID 0)
-- Dependencies: 197
-- Name: COLUMN noticia.noti_nombre; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON COLUMN noticia.noti_nombre IS 'Nombre de la noticia';


--
-- TOC entry 3064 (class 0 OID 0)
-- Dependencies: 197
-- Name: COLUMN noticia.noti_descripcion; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON COLUMN noticia.noti_descripcion IS 'Descripción de la noticia';


--
-- TOC entry 3065 (class 0 OID 0)
-- Dependencies: 197
-- Name: COLUMN noticia.noti_enlace; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON COLUMN noticia.noti_enlace IS 'Enlace de la noticia';


--
-- TOC entry 3066 (class 0 OID 0)
-- Dependencies: 197
-- Name: COLUMN noticia.noti_tipo; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON COLUMN noticia.noti_tipo IS 'Identificador del tipo de noticia que es (general, institucional o proyecto)';


--
-- TOC entry 3067 (class 0 OID 0)
-- Dependencies: 197
-- Name: COLUMN noticia.noti_finicio; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON COLUMN noticia.noti_finicio IS 'Fecha de inicio';


--
-- TOC entry 3068 (class 0 OID 0)
-- Dependencies: 197
-- Name: COLUMN noticia.noti_ffin; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON COLUMN noticia.noti_ffin IS 'Fecha de finalizacion de vigencia de noticia';


--
-- TOC entry 3069 (class 0 OID 0)
-- Dependencies: 197
-- Name: COLUMN noticia.noti_estado; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON COLUMN noticia.noti_estado IS 'Estado de la noticia, 1->activa, 0->inactiva';


--
-- TOC entry 3070 (class 0 OID 0)
-- Dependencies: 197
-- Name: COLUMN noticia.noti_anio; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON COLUMN noticia.noti_anio IS 'Año de vigencia y publicacion de la noticia';


--
-- TOC entry 3071 (class 0 OID 0)
-- Dependencies: 197
-- Name: COLUMN noticia.noti_periodo; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON COLUMN noticia.noti_periodo IS 'Periodo de vigencia y publicacion de la noticia';


--
-- TOC entry 3072 (class 0 OID 0)
-- Dependencies: 197
-- Name: COLUMN noticia.noti_fradicacion; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON COLUMN noticia.noti_fradicacion IS 'Fecha y hora de la publicación de la noticia';


--
-- TOC entry 3073 (class 0 OID 0)
-- Dependencies: 197
-- Name: COLUMN noticia.noti_usr_remi; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON COLUMN noticia.noti_usr_remi IS 'Nombre del usuario que creo que la noticia';


--
-- TOC entry 3074 (class 0 OID 0)
-- Dependencies: 197
-- Name: COLUMN noticia.noti_img_usr_enlace; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON COLUMN noticia.noti_img_usr_enlace IS 'Enlace de la imagen del usuario que creo la notificacion';


--
-- TOC entry 198 (class 1259 OID 136017)
-- Name: notificacion; Type: TABLE; Schema: general; Owner: usuariourano; Tablespace: 
--

CREATE TABLE notificacion (
    id_notifi bigint DEFAULT nextval(('general."id_notificacion_seq"'::text)::regclass) NOT NULL,
    notifi_usr_receptor bigint NOT NULL,
    notifi_titulo character(100) NOT NULL,
    notifi_conte character(200) NOT NULL,
    notifi_fecha_crea timestamp without time zone NOT NULL,
    notifi_estado bigint NOT NULL,
    notifi_usr_emisor bigint NOT NULL,
    notifi_enlace character(50),
    notifi_imagen character(200),
    notifi_tipo character(50) NOT NULL
);


ALTER TABLE general.notificacion OWNER TO usuariourano;

--
-- TOC entry 3075 (class 0 OID 0)
-- Dependencies: 198
-- Name: TABLE notificacion; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON TABLE notificacion IS 'Tabla para almacenar las notificaciones de los usuarios en el sistema';


--
-- TOC entry 3076 (class 0 OID 0)
-- Dependencies: 198
-- Name: COLUMN notificacion.id_notifi; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON COLUMN notificacion.id_notifi IS 'Identificador de la notificación';


--
-- TOC entry 3077 (class 0 OID 0)
-- Dependencies: 198
-- Name: COLUMN notificacion.notifi_usr_receptor; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON COLUMN notificacion.notifi_usr_receptor IS 'Identificador del usuario que crea la notificacion';


--
-- TOC entry 3078 (class 0 OID 0)
-- Dependencies: 198
-- Name: COLUMN notificacion.notifi_titulo; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON COLUMN notificacion.notifi_titulo IS 'Titulo de la notificacion';


--
-- TOC entry 3079 (class 0 OID 0)
-- Dependencies: 198
-- Name: COLUMN notificacion.notifi_conte; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON COLUMN notificacion.notifi_conte IS 'Contenido de la notificacion';


--
-- TOC entry 3080 (class 0 OID 0)
-- Dependencies: 198
-- Name: COLUMN notificacion.notifi_fecha_crea; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON COLUMN notificacion.notifi_fecha_crea IS 'Fecha de la creación de la notificación';


--
-- TOC entry 3081 (class 0 OID 0)
-- Dependencies: 198
-- Name: COLUMN notificacion.notifi_estado; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON COLUMN notificacion.notifi_estado IS 'Identificador del estado de la notificación';


--
-- TOC entry 3082 (class 0 OID 0)
-- Dependencies: 198
-- Name: COLUMN notificacion.notifi_usr_emisor; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON COLUMN notificacion.notifi_usr_emisor IS 'Identificador del usuario que emite o crea la notificación';


--
-- TOC entry 3083 (class 0 OID 0)
-- Dependencies: 198
-- Name: COLUMN notificacion.notifi_enlace; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON COLUMN notificacion.notifi_enlace IS 'Enlace de la notificación';


--
-- TOC entry 3084 (class 0 OID 0)
-- Dependencies: 198
-- Name: COLUMN notificacion.notifi_imagen; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON COLUMN notificacion.notifi_imagen IS 'Dirección de la imagen de la notificacion, sino se ingresa ninguna se mostrará la de por defecto';


--
-- TOC entry 3085 (class 0 OID 0)
-- Dependencies: 198
-- Name: COLUMN notificacion.notifi_tipo; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON COLUMN notificacion.notifi_tipo IS 'Identificador del tipo de la notificación';


--
-- TOC entry 195 (class 1259 OID 135958)
-- Name: tipo_noticia; Type: TABLE; Schema: general; Owner: usuariourano; Tablespace: 
--

CREATE TABLE tipo_noticia (
    id_tipo bigint DEFAULT nextval(('general."id_tipo_noticia_seq"'::text)::regclass) NOT NULL,
    nombre character(50) NOT NULL,
    descripcion character(100) NOT NULL
);


ALTER TABLE general.tipo_noticia OWNER TO usuariourano;

--
-- TOC entry 3086 (class 0 OID 0)
-- Dependencies: 195
-- Name: COLUMN tipo_noticia.id_tipo; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON COLUMN tipo_noticia.id_tipo IS 'Identificador del tipo de noticia';


--
-- TOC entry 3087 (class 0 OID 0)
-- Dependencies: 195
-- Name: COLUMN tipo_noticia.nombre; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON COLUMN tipo_noticia.nombre IS 'Nombre del tipo de noticia que se registra';


--
-- TOC entry 3088 (class 0 OID 0)
-- Dependencies: 195
-- Name: COLUMN tipo_noticia.descripcion; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON COLUMN tipo_noticia.descripcion IS 'Descripcion corta del tipo de noticia ';


--
-- TOC entry 196 (class 1259 OID 135970)
-- Name: tipo_notifi; Type: TABLE; Schema: general; Owner: usuariourano; Tablespace: 
--

CREATE TABLE tipo_notifi (
    id_tipo character(5) DEFAULT nextval(('general."id_tipo_notifi_seq"'::text)::regclass) NOT NULL,
    nombre character(50),
    img_tipo character(100)
);


ALTER TABLE general.tipo_notifi OWNER TO usuariourano;

--
-- TOC entry 3089 (class 0 OID 0)
-- Dependencies: 196
-- Name: COLUMN tipo_notifi.id_tipo; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON COLUMN tipo_notifi.id_tipo IS 'Identificador del tipo de notificación, en abreviatura';


--
-- TOC entry 3090 (class 0 OID 0)
-- Dependencies: 196
-- Name: COLUMN tipo_notifi.nombre; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON COLUMN tipo_notifi.nombre IS 'Nombre del tipo de la notificación';


--
-- TOC entry 3091 (class 0 OID 0)
-- Dependencies: 196
-- Name: COLUMN tipo_notifi.img_tipo; Type: COMMENT; Schema: general; Owner: usuariourano
--

COMMENT ON COLUMN tipo_notifi.img_tipo IS 'Enlace de la imagen para el tipo de notificación
';


SET search_path = public, pg_catalog;

--
-- TOC entry 170 (class 1259 OID 132467)
-- Name: urano_bloque; Type: TABLE; Schema: public; Owner: usuariourano; Tablespace: 
--

CREATE TABLE urano_bloque (
    id_bloque integer NOT NULL,
    nombre character(50) NOT NULL,
    descripcion character(255) DEFAULT NULL::bpchar,
    grupo character(200) NOT NULL
);


ALTER TABLE public.urano_bloque OWNER TO usuariourano;

--
-- TOC entry 169 (class 1259 OID 132465)
-- Name: urano_bloque_id_bloque_seq; Type: SEQUENCE; Schema: public; Owner: usuariourano
--

CREATE SEQUENCE urano_bloque_id_bloque_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.urano_bloque_id_bloque_seq OWNER TO usuariourano;

--
-- TOC entry 3092 (class 0 OID 0)
-- Dependencies: 169
-- Name: urano_bloque_id_bloque_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: usuariourano
--

ALTER SEQUENCE urano_bloque_id_bloque_seq OWNED BY urano_bloque.id_bloque;


--
-- TOC entry 172 (class 1259 OID 132479)
-- Name: urano_bloque_pagina; Type: TABLE; Schema: public; Owner: usuariourano; Tablespace: 
--

CREATE TABLE urano_bloque_pagina (
    idrelacion integer NOT NULL,
    id_pagina integer DEFAULT 0 NOT NULL,
    id_bloque integer DEFAULT 0 NOT NULL,
    seccion character(1) NOT NULL,
    posicion integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.urano_bloque_pagina OWNER TO usuariourano;

--
-- TOC entry 171 (class 1259 OID 132477)
-- Name: urano_bloque_pagina_idrelacion_seq; Type: SEQUENCE; Schema: public; Owner: usuariourano
--

CREATE SEQUENCE urano_bloque_pagina_idrelacion_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.urano_bloque_pagina_idrelacion_seq OWNER TO usuariourano;

--
-- TOC entry 3093 (class 0 OID 0)
-- Dependencies: 171
-- Name: urano_bloque_pagina_idrelacion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: usuariourano
--

ALTER SEQUENCE urano_bloque_pagina_idrelacion_seq OWNED BY urano_bloque_pagina.idrelacion;


--
-- TOC entry 174 (class 1259 OID 132490)
-- Name: urano_configuracion; Type: TABLE; Schema: public; Owner: usuariourano; Tablespace: 
--

CREATE TABLE urano_configuracion (
    id_parametro integer NOT NULL,
    parametro character(255) NOT NULL,
    valor character(255) NOT NULL
);


ALTER TABLE public.urano_configuracion OWNER TO usuariourano;

--
-- TOC entry 173 (class 1259 OID 132488)
-- Name: urano_configuracion_id_parametro_seq; Type: SEQUENCE; Schema: public; Owner: usuariourano
--

CREATE SEQUENCE urano_configuracion_id_parametro_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.urano_configuracion_id_parametro_seq OWNER TO usuariourano;

--
-- TOC entry 3094 (class 0 OID 0)
-- Dependencies: 173
-- Name: urano_configuracion_id_parametro_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: usuariourano
--

ALTER SEQUENCE urano_configuracion_id_parametro_seq OWNED BY urano_configuracion.id_parametro;


--
-- TOC entry 176 (class 1259 OID 132501)
-- Name: urano_dbms; Type: TABLE; Schema: public; Owner: usuariourano; Tablespace: 
--

CREATE TABLE urano_dbms (
    idconexion integer NOT NULL,
    nombre character varying(50) NOT NULL,
    dbms character varying(20) NOT NULL,
    servidor character varying(50) NOT NULL,
    puerto integer NOT NULL,
    conexionssh character varying(50) NOT NULL,
    db character varying(100) NOT NULL,
    esquema character varying(100) NOT NULL,
    usuario character varying(100) NOT NULL,
    password character varying(200) NOT NULL
);


ALTER TABLE public.urano_dbms OWNER TO usuariourano;

--
-- TOC entry 175 (class 1259 OID 132499)
-- Name: urano_dbms_idconexion_seq; Type: SEQUENCE; Schema: public; Owner: usuariourano
--

CREATE SEQUENCE urano_dbms_idconexion_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.urano_dbms_idconexion_seq OWNER TO usuariourano;

--
-- TOC entry 3095 (class 0 OID 0)
-- Dependencies: 175
-- Name: urano_dbms_idconexion_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: usuariourano
--

ALTER SEQUENCE urano_dbms_idconexion_seq OWNED BY urano_dbms.idconexion;


--
-- TOC entry 206 (class 1259 OID 136085)
-- Name: urano_enlace; Type: TABLE; Schema: public; Owner: usuariourano; Tablespace: 
--

CREATE TABLE urano_enlace (
    id_enlace integer NOT NULL,
    id_subsistema_sga smallint,
    nombre character varying(255),
    etiqueta character varying(100) NOT NULL,
    descripcion character varying(100) NOT NULL,
    url_host_enlace character varying(100),
    pagina_enlace character varying(100) NOT NULL,
    parametros character varying(255) NOT NULL
);


ALTER TABLE public.urano_enlace OWNER TO usuariourano;

--
-- TOC entry 3096 (class 0 OID 0)
-- Dependencies: 206
-- Name: COLUMN urano_enlace.url_host_enlace; Type: COMMENT; Schema: public; Owner: usuariourano
--

COMMENT ON COLUMN urano_enlace.url_host_enlace IS 'Si es un enlace fuera del sistema, o sea un enlace estático';


--
-- TOC entry 3097 (class 0 OID 0)
-- Dependencies: 206
-- Name: COLUMN urano_enlace.parametros; Type: COMMENT; Schema: public; Owner: usuariourano
--

COMMENT ON COLUMN urano_enlace.parametros IS 'Parametros estilo php, para funcionamiento de la página. par=1&par2=2';


--
-- TOC entry 205 (class 1259 OID 136083)
-- Name: urano_enlace_id_enlace_seq; Type: SEQUENCE; Schema: public; Owner: usuariourano
--

CREATE SEQUENCE urano_enlace_id_enlace_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.urano_enlace_id_enlace_seq OWNER TO usuariourano;

--
-- TOC entry 3098 (class 0 OID 0)
-- Dependencies: 205
-- Name: urano_enlace_id_enlace_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: usuariourano
--

ALTER SEQUENCE urano_enlace_id_enlace_seq OWNED BY urano_enlace.id_enlace;


--
-- TOC entry 177 (class 1259 OID 132510)
-- Name: urano_estilo; Type: TABLE; Schema: public; Owner: usuariourano; Tablespace: 
--

CREATE TABLE urano_estilo (
    usuario character(50) DEFAULT '0'::bpchar NOT NULL,
    estilo character(50) NOT NULL
);


ALTER TABLE public.urano_estilo OWNER TO usuariourano;

--
-- TOC entry 204 (class 1259 OID 136071)
-- Name: urano_grupo_menu; Type: TABLE; Schema: public; Owner: usuariourano; Tablespace: 
--

CREATE TABLE urano_grupo_menu (
    id_grupo_menu integer NOT NULL,
    id_menu integer NOT NULL,
    nombre character varying(255) NOT NULL,
    etiqueta character varying(100) NOT NULL,
    descripcion character varying(100) NOT NULL,
    estado boolean DEFAULT true NOT NULL,
    id_grupo_padre integer,
    peso integer
);


ALTER TABLE public.urano_grupo_menu OWNER TO usuariourano;

--
-- TOC entry 3099 (class 0 OID 0)
-- Dependencies: 204
-- Name: COLUMN urano_grupo_menu.peso; Type: COMMENT; Schema: public; Owner: usuariourano
--

COMMENT ON COLUMN urano_grupo_menu.peso IS 'El peso es un número que nos dice que entre menor sea el número, el submenú estará más arriba en la posición del menú, y entre mayor sea el número, más pesado será el grupo menú y por eso estará de último';


--
-- TOC entry 203 (class 1259 OID 136069)
-- Name: urano_grupo_menu_id_grupo_menu_seq; Type: SEQUENCE; Schema: public; Owner: usuariourano
--

CREATE SEQUENCE urano_grupo_menu_id_grupo_menu_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.urano_grupo_menu_id_grupo_menu_seq OWNER TO usuariourano;

--
-- TOC entry 3100 (class 0 OID 0)
-- Dependencies: 203
-- Name: urano_grupo_menu_id_grupo_menu_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: usuariourano
--

ALTER SEQUENCE urano_grupo_menu_id_grupo_menu_seq OWNED BY urano_grupo_menu.id_grupo_menu;


--
-- TOC entry 179 (class 1259 OID 132518)
-- Name: urano_logger; Type: TABLE; Schema: public; Owner: usuariourano; Tablespace: 
--

CREATE TABLE urano_logger (
    id integer NOT NULL,
    evento character(255) NOT NULL,
    fecha character(50) NOT NULL
);


ALTER TABLE public.urano_logger OWNER TO usuariourano;

--
-- TOC entry 178 (class 1259 OID 132516)
-- Name: urano_logger_id_seq; Type: SEQUENCE; Schema: public; Owner: usuariourano
--

CREATE SEQUENCE urano_logger_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.urano_logger_id_seq OWNER TO usuariourano;

--
-- TOC entry 3101 (class 0 OID 0)
-- Dependencies: 178
-- Name: urano_logger_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: usuariourano
--

ALTER SEQUENCE urano_logger_id_seq OWNED BY urano_logger.id;


--
-- TOC entry 202 (class 1259 OID 136059)
-- Name: urano_menu; Type: TABLE; Schema: public; Owner: usuariourano; Tablespace: 
--

CREATE TABLE urano_menu (
    id_menu integer NOT NULL,
    nombre character varying(255) NOT NULL,
    etiqueta character varying(100),
    descripcion text NOT NULL,
    estado boolean DEFAULT true NOT NULL,
    peso integer
);


ALTER TABLE public.urano_menu OWNER TO usuariourano;

--
-- TOC entry 3102 (class 0 OID 0)
-- Dependencies: 202
-- Name: COLUMN urano_menu.peso; Type: COMMENT; Schema: public; Owner: usuariourano
--

COMMENT ON COLUMN urano_menu.peso IS 'El peso es un número que nos dice que entre menor sea el número, menú estará más arriba en la posición de la barra de menús, y entre mayor sea el número, más pesado será el menú y por eso estará de último.';


--
-- TOC entry 201 (class 1259 OID 136057)
-- Name: urano_menu_id_menu_seq; Type: SEQUENCE; Schema: public; Owner: usuariourano
--

CREATE SEQUENCE urano_menu_id_menu_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.urano_menu_id_menu_seq OWNER TO usuariourano;

--
-- TOC entry 3103 (class 0 OID 0)
-- Dependencies: 201
-- Name: urano_menu_id_menu_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: usuariourano
--

ALTER SEQUENCE urano_menu_id_menu_seq OWNED BY urano_menu.id_menu;


--
-- TOC entry 181 (class 1259 OID 132524)
-- Name: urano_pagina; Type: TABLE; Schema: public; Owner: usuariourano; Tablespace: 
--

CREATE TABLE urano_pagina (
    id_pagina integer NOT NULL,
    nombre character(50) DEFAULT ''::bpchar NOT NULL,
    descripcion character(250) DEFAULT ''::bpchar NOT NULL,
    modulo character(50) DEFAULT ''::bpchar NOT NULL,
    nivel integer DEFAULT 0 NOT NULL,
    parametro character(255) NOT NULL
);


ALTER TABLE public.urano_pagina OWNER TO usuariourano;

--
-- TOC entry 180 (class 1259 OID 132522)
-- Name: urano_pagina_id_pagina_seq; Type: SEQUENCE; Schema: public; Owner: usuariourano
--

CREATE SEQUENCE urano_pagina_id_pagina_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.urano_pagina_id_pagina_seq OWNER TO usuariourano;

--
-- TOC entry 3104 (class 0 OID 0)
-- Dependencies: 180
-- Name: urano_pagina_id_pagina_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: usuariourano
--

ALTER SEQUENCE urano_pagina_id_pagina_seq OWNED BY urano_pagina.id_pagina;


--
-- TOC entry 200 (class 1259 OID 136050)
-- Name: urano_rol; Type: TABLE; Schema: public; Owner: usuariourano; Tablespace: 
--

CREATE TABLE urano_rol (
    id_rol integer NOT NULL,
    nombre character varying(50) NOT NULL,
    alias character varying(50) NOT NULL,
    descripcion character varying(100) NOT NULL,
    estado boolean DEFAULT true NOT NULL,
    fecha_registro date DEFAULT ('now'::text)::date NOT NULL
);


ALTER TABLE public.urano_rol OWNER TO usuariourano;

--
-- TOC entry 207 (class 1259 OID 136102)
-- Name: urano_servicio; Type: TABLE; Schema: public; Owner: usuariourano; Tablespace: 
--

CREATE TABLE urano_servicio (
    id_rol integer NOT NULL,
    id_grupo_menu integer NOT NULL,
    id_enlace integer NOT NULL,
    descripcion character varying(100) NOT NULL,
    estado boolean DEFAULT true NOT NULL
);


ALTER TABLE public.urano_servicio OWNER TO usuariourano;

--
-- TOC entry 186 (class 1259 OID 132565)
-- Name: urano_subsistema; Type: TABLE; Schema: public; Owner: usuariourano; Tablespace: 
--

CREATE TABLE urano_subsistema (
    id_subsistema integer NOT NULL,
    nombre character varying(250) NOT NULL,
    etiqueta character varying(100) NOT NULL,
    id_pagina integer DEFAULT 0 NOT NULL,
    observacion text
);


ALTER TABLE public.urano_subsistema OWNER TO usuariourano;

--
-- TOC entry 185 (class 1259 OID 132563)
-- Name: urano_subsistema_id_subsistema_seq; Type: SEQUENCE; Schema: public; Owner: usuariourano
--

CREATE SEQUENCE urano_subsistema_id_subsistema_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.urano_subsistema_id_subsistema_seq OWNER TO usuariourano;

--
-- TOC entry 3105 (class 0 OID 0)
-- Dependencies: 185
-- Name: urano_subsistema_id_subsistema_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: usuariourano
--

ALTER SEQUENCE urano_subsistema_id_subsistema_seq OWNED BY urano_subsistema.id_subsistema;


--
-- TOC entry 199 (class 1259 OID 136039)
-- Name: urano_subsistema_sga; Type: TABLE; Schema: public; Owner: usuariourano; Tablespace: 
--

CREATE TABLE urano_subsistema_sga (
    id_subsistema_sga smallint NOT NULL,
    nombre character varying(50) NOT NULL,
    host character varying(50) NOT NULL,
    ruta character varying(100) NOT NULL,
    codificado boolean NOT NULL,
    indice_codificador character varying(50) NOT NULL,
    funcion_codificador character varying(50) NOT NULL
);


ALTER TABLE public.urano_subsistema_sga OWNER TO usuariourano;

--
-- TOC entry 187 (class 1259 OID 132575)
-- Name: urano_tempformulario; Type: TABLE; Schema: public; Owner: usuariourano; Tablespace: 
--

CREATE TABLE urano_tempformulario (
    id_sesion character(32) NOT NULL,
    formulario character(100) NOT NULL,
    campo character(100) NOT NULL,
    valor text NOT NULL,
    fecha character(50) NOT NULL
);


ALTER TABLE public.urano_tempformulario OWNER TO usuariourano;

--
-- TOC entry 183 (class 1259 OID 132539)
-- Name: urano_usuario; Type: TABLE; Schema: public; Owner: usuariourano; Tablespace: 
--

CREATE TABLE urano_usuario (
    id_usuario integer NOT NULL,
    nombre character varying(50) DEFAULT ''::character varying NOT NULL,
    apellido character varying(50) DEFAULT ''::character varying NOT NULL,
    correo character varying(100) DEFAULT ''::character varying NOT NULL,
    telefono character varying(50) DEFAULT ''::character varying NOT NULL,
    imagen character(255) NOT NULL,
    clave character varying(100) DEFAULT ''::character varying NOT NULL,
    tipo character varying(255) DEFAULT ''::character varying NOT NULL,
    estilo character varying(50) DEFAULT 'basico'::character varying NOT NULL,
    idioma character varying(50) DEFAULT 'es_es'::character varying NOT NULL,
    estado integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.urano_usuario OWNER TO usuariourano;

--
-- TOC entry 182 (class 1259 OID 132537)
-- Name: urano_usuario_id_usuario_seq; Type: SEQUENCE; Schema: public; Owner: usuariourano
--

CREATE SEQUENCE urano_usuario_id_usuario_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.urano_usuario_id_usuario_seq OWNER TO usuariourano;

--
-- TOC entry 3106 (class 0 OID 0)
-- Dependencies: 182
-- Name: urano_usuario_id_usuario_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: usuariourano
--

ALTER SEQUENCE urano_usuario_id_usuario_seq OWNED BY urano_usuario.id_usuario;


--
-- TOC entry 184 (class 1259 OID 132557)
-- Name: urano_usuario_subsistema; Type: TABLE; Schema: public; Owner: usuariourano; Tablespace: 
--

CREATE TABLE urano_usuario_subsistema (
    id_usuario integer DEFAULT 0 NOT NULL,
    id_subsistema integer DEFAULT 0 NOT NULL,
    estado integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.urano_usuario_subsistema OWNER TO usuariourano;

--
-- TOC entry 188 (class 1259 OID 132581)
-- Name: urano_valor_sesion; Type: TABLE; Schema: public; Owner: usuariourano; Tablespace: 
--

CREATE TABLE urano_valor_sesion (
    sesionid character(32) NOT NULL,
    variable character(20) NOT NULL,
    valor character(255) NOT NULL,
    expiracion bigint DEFAULT 0 NOT NULL
);


ALTER TABLE public.urano_valor_sesion OWNER TO usuariourano;

--
-- TOC entry 2808 (class 2604 OID 132470)
-- Name: id_bloque; Type: DEFAULT; Schema: public; Owner: usuariourano
--

ALTER TABLE ONLY urano_bloque ALTER COLUMN id_bloque SET DEFAULT nextval('urano_bloque_id_bloque_seq'::regclass);


--
-- TOC entry 2810 (class 2604 OID 132482)
-- Name: idrelacion; Type: DEFAULT; Schema: public; Owner: usuariourano
--

ALTER TABLE ONLY urano_bloque_pagina ALTER COLUMN idrelacion SET DEFAULT nextval('urano_bloque_pagina_idrelacion_seq'::regclass);


--
-- TOC entry 2814 (class 2604 OID 132493)
-- Name: id_parametro; Type: DEFAULT; Schema: public; Owner: usuariourano
--

ALTER TABLE ONLY urano_configuracion ALTER COLUMN id_parametro SET DEFAULT nextval('urano_configuracion_id_parametro_seq'::regclass);


--
-- TOC entry 2815 (class 2604 OID 132504)
-- Name: idconexion; Type: DEFAULT; Schema: public; Owner: usuariourano
--

ALTER TABLE ONLY urano_dbms ALTER COLUMN idconexion SET DEFAULT nextval('urano_dbms_idconexion_seq'::regclass);


--
-- TOC entry 2850 (class 2604 OID 136088)
-- Name: id_enlace; Type: DEFAULT; Schema: public; Owner: usuariourano
--

ALTER TABLE ONLY urano_enlace ALTER COLUMN id_enlace SET DEFAULT nextval('urano_enlace_id_enlace_seq'::regclass);


--
-- TOC entry 2848 (class 2604 OID 136074)
-- Name: id_grupo_menu; Type: DEFAULT; Schema: public; Owner: usuariourano
--

ALTER TABLE ONLY urano_grupo_menu ALTER COLUMN id_grupo_menu SET DEFAULT nextval('urano_grupo_menu_id_grupo_menu_seq'::regclass);


--
-- TOC entry 2817 (class 2604 OID 132521)
-- Name: id; Type: DEFAULT; Schema: public; Owner: usuariourano
--

ALTER TABLE ONLY urano_logger ALTER COLUMN id SET DEFAULT nextval('urano_logger_id_seq'::regclass);


--
-- TOC entry 2846 (class 2604 OID 136062)
-- Name: id_menu; Type: DEFAULT; Schema: public; Owner: usuariourano
--

ALTER TABLE ONLY urano_menu ALTER COLUMN id_menu SET DEFAULT nextval('urano_menu_id_menu_seq'::regclass);


--
-- TOC entry 2818 (class 2604 OID 132527)
-- Name: id_pagina; Type: DEFAULT; Schema: public; Owner: usuariourano
--

ALTER TABLE ONLY urano_pagina ALTER COLUMN id_pagina SET DEFAULT nextval('urano_pagina_id_pagina_seq'::regclass);


--
-- TOC entry 2836 (class 2604 OID 132568)
-- Name: id_subsistema; Type: DEFAULT; Schema: public; Owner: usuariourano
--

ALTER TABLE ONLY urano_subsistema ALTER COLUMN id_subsistema SET DEFAULT nextval('urano_subsistema_id_subsistema_seq'::regclass);


--
-- TOC entry 2823 (class 2604 OID 132542)
-- Name: id_usuario; Type: DEFAULT; Schema: public; Owner: usuariourano
--

ALTER TABLE ONLY urano_usuario ALTER COLUMN id_usuario SET DEFAULT nextval('urano_usuario_id_usuario_seq'::regclass);


SET search_path = general, pg_catalog;

--
-- TOC entry 3029 (class 0 OID 135865)
-- Dependencies: 189
-- Data for Name: est_noti; Type: TABLE DATA; Schema: general; Owner: usuariourano
--

INSERT INTO est_noti VALUES (0, 'inactivo                                          ');
INSERT INTO est_noti VALUES (1, 'activo                                            ');
INSERT INTO est_noti VALUES (2, 'suspendido                                        ');


--
-- TOC entry 3030 (class 0 OID 135875)
-- Dependencies: 190
-- Data for Name: est_notifi; Type: TABLE DATA; Schema: general; Owner: usuariourano
--

INSERT INTO est_notifi VALUES (0, 'Ignorada                                          ');
INSERT INTO est_notifi VALUES (1, 'Pendiente                                         ');
INSERT INTO est_notifi VALUES (2, 'Vista                                             ');


--
-- TOC entry 3107 (class 0 OID 0)
-- Dependencies: 191
-- Name: id_noticia_seq; Type: SEQUENCE SET; Schema: general; Owner: usuariourano
--

SELECT pg_catalog.setval('id_noticia_seq', 1, false);


--
-- TOC entry 3108 (class 0 OID 0)
-- Dependencies: 192
-- Name: id_notificacion_seq; Type: SEQUENCE SET; Schema: general; Owner: usuariourano
--

SELECT pg_catalog.setval('id_notificacion_seq', 17, false);


--
-- TOC entry 3109 (class 0 OID 0)
-- Dependencies: 193
-- Name: id_tipo_noticia_seq; Type: SEQUENCE SET; Schema: general; Owner: usuariourano
--

SELECT pg_catalog.setval('id_tipo_noticia_seq', 1, false);


--
-- TOC entry 3110 (class 0 OID 0)
-- Dependencies: 194
-- Name: id_tipo_notifi_seq; Type: SEQUENCE SET; Schema: general; Owner: usuariourano
--

SELECT pg_catalog.setval('id_tipo_notifi_seq', 5, false);


--
-- TOC entry 3037 (class 0 OID 135996)
-- Dependencies: 197
-- Data for Name: noticia; Type: TABLE DATA; Schema: general; Owner: usuariourano
--

INSERT INTO noticia VALUES (1, 'Modificación Calendario Académico 2016                                                              ', 'Consulte la [Circular No. 001] de Vicerrectoría Académica en la que se modifican fechas del Calendario Académico.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       ', 'https://condor.udistrital.edu.co/descargas/circular_001_2016.pdf                                    ', 1, '2016-01-01', '2016-10-08', 1, 2016, 1, '2016-01-01 00:00:00', 'Coordinación                                      ', 'escudo2.png                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             ');
INSERT INTO noticia VALUES (2, 'ALERTA, MENSAJE DE SEGURIDAD!!!                                                                     ', 'Recomendaciones generales para el manejo de claves y demás [ver más]...                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 ', NULL, 1, '2016-01-01', '2016-10-08', 1, 2016, 1, '2016-02-03 04:05:26', 'OAS                                               ', 'oas.png                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 ');
INSERT INTO noticia VALUES (3, 'HORARIOS 2016-1                                                                                     ', 'Ya fueron publicados los nuevos horarios para el año 2016, en el primer periodo del año, para descargarlos acced al siguiente enlace [Descargar]...                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     ', 'https://www.dropbox.com/sh/61jzu4e33xaqa18/AACQOWdyMIBmIuH7pAwOPPspa?dl=0                           ', 1, '2016-01-01', '2016-10-08', 1, 2016, 1, '2016-03-04 05:06:07', 'Proyecto curricular                               ', 'acreditacion.png                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ');
INSERT INTO noticia VALUES (4, 'Calendario Académico 2016-1                                                                         ', 'Calendario académico para el año 2016 [ver más]...                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      ', NULL, 1, '2016-01-01', '2016-10-08', 1, 2016, 1, '2016-04-05 06:07:08', 'Coordinación                                      ', 'escudo2.png                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             ');
INSERT INTO noticia VALUES (5, 'Franjas adiciones y cancelaciones 2016-1                                                            ', 'Ya fueron estipuladas las franjas para adiciones y cancelaciones para el presente periodo academico, si desea verlos ingrese en [ver más]...                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            ', NULL, 1, '2016-01-01', '2016-12-31', 1, 2016, 1, '2016-05-06 07:08:09', 'Coordinación                                      ', NULL);
INSERT INTO noticia VALUES (6, 'IMPORTANTE, CAMBIO DE CLAVES!                                                                       ', 'Se realiza recomendación para el manejo de la clave personal para el ingreso a la plataforma [ver más]...                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               ', NULL, 1, '2016-01-01', '2020-12-31', 1, 2016, 1, '2016-06-07 08:09:10', 'OAS                                               ', 'oas.png                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 ');
INSERT INTO noticia VALUES (7, 'Apoyo alimentario                                                                                   ', 'Se amplia el plazo para entrega de papeles de apoyo alimentario                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         ', NULL, 1, '2016-04-11', '2016-04-25', 1, 2016, 1, '2016-04-11 02:49:26', 'Bienestar universitario                           ', 'bienestar.jpg                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           ');


--
-- TOC entry 3038 (class 0 OID 136017)
-- Dependencies: 198
-- Data for Name: notificacion; Type: TABLE DATA; Schema: general; Owner: usuariourano
--

INSERT INTO notificacion VALUES (1, 6666, 'Aún no se han evaluado a los docentes                                                               ', 'Se hace necesario la evaluación de los docentes                                                                                                                                                         ', '2016-04-15 09:51:45', 0, 1234, NULL, NULL, 'ALE                                               ');
INSERT INTO notificacion VALUES (2, 6666, 'Nuevo mensaje de coordinación                                                                       ', 'Ha recibido un mensaje de coordinación...                                                                                                                                                               ', '2016-04-16 10:51:26', 1, 1111, NULL, NULL, 'MSJ                                               ');
INSERT INTO notificacion VALUES (3, 6666, 'Convocatoria representantes estudiantiles consejo de carrera                                        ', 'Texto de prueba                                                                                                                                                                                         ', '2016-04-16 15:32:39', 2, 1234, NULL, NULL, 'MSJ                                               ');
INSERT INTO notificacion VALUES (4, 6666, 'Oferta Pasantía                                                                                     ', 'Texto de prueba                                                                                                                                                                                         ', '2016-04-16 15:32:39', 1, 1234, NULL, NULL, 'MSJ                                               ');
INSERT INTO notificacion VALUES (5, 6666, 'Oferta laboral Informatica ICFE                                                                     ', 'Texto de prueba                                                                                                                                                                                         ', '2016-04-16 15:32:39', 2, 1234, NULL, NULL, 'MSJ                                               ');
INSERT INTO notificacion VALUES (7, 6666, 'Oferta laboral Glolic                                                                               ', 'Texto de prueba                                                                                                                                                                                         ', '2016-04-16 15:32:39', 1, 1234, NULL, NULL, 'MSJ                                               ');
INSERT INTO notificacion VALUES (8, 6666, 'Solicitud practicante Summa                                                                         ', 'Texto de prueba                                                                                                                                                                                         ', '2016-04-16 15:32:39', 2, 1234, NULL, NULL, 'MSJ                                               ');
INSERT INTO notificacion VALUES (9, 6666, 'Oferta Laboral Servilimpieza                                                                        ', 'Texto de prueba                                                                                                                                                                                         ', '2016-04-16 15:32:39', 2, 1234, NULL, NULL, 'MSJ                                               ');
INSERT INTO notificacion VALUES (10, 6666, 'evento UNESCO                                                                                       ', 'Texto de prueba                                                                                                                                                                                         ', '2016-04-16 15:32:39', 1, 1234, NULL, NULL, 'MSJ                                               ');
INSERT INTO notificacion VALUES (11, 6666, 'Consejerias                                                                                         ', 'Texto de prueba                                                                                                                                                                                         ', '2016-04-16 15:32:39', 2, 1234, NULL, NULL, 'MSJ                                               ');
INSERT INTO notificacion VALUES (12, 6666, 'Hoy martes 08 de marzo inicio clases de Valorización grupo 61 y 63                                  ', 'Texto de prueba                                                                                                                                                                                         ', '2016-04-16 15:32:39', 1, 1234, NULL, NULL, 'MSJ                                               ');
INSERT INTO notificacion VALUES (14, 6666, 'No clases esta semana de Probabilidad grupos 61 y 64 con el Docente Hugo Mancera                    ', 'Texto de prueba                                                                                                                                                                                         ', '2016-04-16 15:32:39', 2, 1234, NULL, NULL, 'MSJ                                               ');
INSERT INTO notificacion VALUES (16, 6666, 'Monitores seleccionados periodo Académico 2016-1                                                    ', 'Texto de prueba                                                                                                                                                                                         ', '2016-04-16 15:32:39', 1, 1234, NULL, NULL, 'MSJ                                               ');
INSERT INTO notificacion VALUES (17, 6666, 'Importante para la Comunidad Académica con respecto a solicitudes ante el Consejo de Carrera        ', 'Texto de prueba                                                                                                                                                                                         ', '2016-04-16 15:32:39', 2, 1234, NULL, NULL, 'MSJ                                               ');
INSERT INTO notificacion VALUES (13, 6666, 'Invitación a misa del Profesor Rafael D''Luyz al cumplir un mes de fallecimiento                     ', 'Texto de prueba                                                                                                                                                                                         ', '2016-04-16 15:32:39', 2, 1234, NULL, NULL, 'ALE                                               ');
INSERT INTO notificacion VALUES (6, 6666, 'Oferta laboral inalambria                                                                           ', 'Texto de prueba                                                                                                                                                                                         ', '2016-04-16 15:32:39', 1, 1234, NULL, NULL, 'ALE                                               ');
INSERT INTO notificacion VALUES (15, 6666, 'Se requiere de un Ingeniero Catastral ONG CORPORACION COLOMBIA NATURALEZA Y VIDA                    ', 'Texto de prueba                                                                                                                                                                                         ', '2016-04-16 15:32:39', 2, 1234, NULL, NULL, 'ALE                                               ');


--
-- TOC entry 3035 (class 0 OID 135958)
-- Dependencies: 195
-- Data for Name: tipo_noticia; Type: TABLE DATA; Schema: general; Owner: usuariourano
--

INSERT INTO tipo_noticia VALUES (1, 'Institucional                                     ', 'Noticia general para todos los usuario registrados en el sistema                                    ');
INSERT INTO tipo_noticia VALUES (2, 'Proyecto                                          ', 'Noticia para todos los usuarios de un proyecto curricular en especifico                             ');
INSERT INTO tipo_noticia VALUES (3, 'Personal                                          ', 'Noticia para un usuario en especifico                                                               ');


--
-- TOC entry 3036 (class 0 OID 135970)
-- Dependencies: 196
-- Data for Name: tipo_notifi; Type: TABLE DATA; Schema: general; Owner: usuariourano
--

INSERT INTO tipo_notifi VALUES ('ALE  ', 'Alerta                                            ', 'alerta.png                                                                                          ');
INSERT INTO tipo_notifi VALUES ('INF  ', 'Información                                       ', 'info.png                                                                                            ');
INSERT INTO tipo_notifi VALUES ('OTR  ', 'Otra                                              ', 'otra.png                                                                                            ');
INSERT INTO tipo_notifi VALUES ('MSJ  ', 'Mensaje                                           ', 'back.png                                                                                            ');


SET search_path = public, pg_catalog;

--
-- TOC entry 3010 (class 0 OID 132467)
-- Dependencies: 170
-- Data for Name: urano_bloque; Type: TABLE DATA; Schema: public; Owner: usuariourano
--

INSERT INTO urano_bloque VALUES (-1, 'menuLateral                                       ', 'Menú lateral módulo de desarrollo.                                                                                                                                                                                                                             ', 'development                                                                                                                                                                                             ');
INSERT INTO urano_bloque VALUES (-2, 'pie                                               ', 'Pie de página módulo de desarrollo.                                                                                                                                                                                                                            ', 'development                                                                                                                                                                                             ');
INSERT INTO urano_bloque VALUES (-3, 'banner                                            ', 'Banner módulo de desarrollo.                                                                                                                                                                                                                                   ', 'development                                                                                                                                                                                             ');
INSERT INTO urano_bloque VALUES (-4, 'cruder                                            ', 'Módulo para crear módulos CRUD.                                                                                                                                                                                                                                ', 'development                                                                                                                                                                                             ');
INSERT INTO urano_bloque VALUES (-5, 'desenlace                                         ', 'Módulo de gestión de desenlace.                                                                                                                                                                                                                                ', 'development                                                                                                                                                                                             ');
INSERT INTO urano_bloque VALUES (-6, 'registro                                          ', 'Módulo para registrar páginas o módulos.                                                                                                                                                                                                                       ', 'development                                                                                                                                                                                             ');
INSERT INTO urano_bloque VALUES (-7, 'constructor                                       ', 'Módulo para diseñar páginas.                                                                                                                                                                                                                                   ', 'development                                                                                                                                                                                             ');
INSERT INTO urano_bloque VALUES (-8, 'contenidoCentral                                  ', 'Contenido página principal de desarrollo.                                                                                                                                                                                                                      ', 'development                                                                                                                                                                                             ');
INSERT INTO urano_bloque VALUES (-9, 'codificador                                       ', 'Módulo para decodificar cadenas.                                                                                                                                                                                                                               ', 'development                                                                                                                                                                                             ');
INSERT INTO urano_bloque VALUES (-10, 'plugin                                            ', 'Módulo para agregar plugin preconfigurados.                                                                                                                                                                                                                    ', 'development                                                                                                                                                                                             ');
INSERT INTO urano_bloque VALUES (-11, 'saraFormCreator                                   ', 'Módulo para crear formulario con la recomendación de bloques de SARA.                                                                                                                                                                                          ', 'development                                                                                                                                                                                             ');
INSERT INTO urano_bloque VALUES (-12, 'formatearSQL                                      ', 'Módulo para formatear cadenas SQL para el archivo SQL.class.php recomendado en SARA.                                                                                                                                                                           ', 'development                                                                                                                                                                                             ');
INSERT INTO urano_bloque VALUES (1, 'inicio                                            ', 'Menú que carga el SPLASH INICIAL                                                                                                                                                                                                                               ', 'gui                                                                                                                                                                                                     ');
INSERT INTO urano_bloque VALUES (2, 'menuPrincipal                                     ', 'Menú con roles                                                                                                                                                                                                                                                 ', 'gui                                                                                                                                                                                                     ');
INSERT INTO urano_bloque VALUES (3, 'home                                              ', 'Página desde donde se despliegan los demás FRAMES                                                                                                                                                                                                              ', 'gui                                                                                                                                                                                                     ');
INSERT INTO urano_bloque VALUES (4, 'pieDePagina                                       ', 'Donde están los links suplementarios                                                                                                                                                                                                                           ', 'gui                                                                                                                                                                                                     ');
INSERT INTO urano_bloque VALUES (5, 'horario                                           ', 'Página para ver el horario                                                                                                                                                                                                                                     ', 'bloquesModelo                                                                                                                                                                                           ');
INSERT INTO urano_bloque VALUES (6, 'bloqueC                                           ', 'Este bloque contiene el IFRAME en el que se muestra el contenido.                                                                                                                                                                                              ', 'gui                                                                                                                                                                                                     ');


--
-- TOC entry 3111 (class 0 OID 0)
-- Dependencies: 169
-- Name: urano_bloque_id_bloque_seq; Type: SEQUENCE SET; Schema: public; Owner: usuariourano
--

SELECT pg_catalog.setval('urano_bloque_id_bloque_seq', 3, true);


--
-- TOC entry 3012 (class 0 OID 132479)
-- Dependencies: 172
-- Data for Name: urano_bloque_pagina; Type: TABLE DATA; Schema: public; Owner: usuariourano
--

INSERT INTO urano_bloque_pagina VALUES (1, -1, -1, 'B', 1);
INSERT INTO urano_bloque_pagina VALUES (2, -1, -2, 'E', 1);
INSERT INTO urano_bloque_pagina VALUES (3, -1, -3, 'A', 1);
INSERT INTO urano_bloque_pagina VALUES (4, -1, -8, 'C', 1);
INSERT INTO urano_bloque_pagina VALUES (5, -2, -1, 'B', 1);
INSERT INTO urano_bloque_pagina VALUES (6, -2, -2, 'E', 1);
INSERT INTO urano_bloque_pagina VALUES (7, -2, -3, 'A', 1);
INSERT INTO urano_bloque_pagina VALUES (8, -2, -4, 'C', 1);
INSERT INTO urano_bloque_pagina VALUES (9, -3, -1, 'B', 1);
INSERT INTO urano_bloque_pagina VALUES (10, -3, -2, 'E', 1);
INSERT INTO urano_bloque_pagina VALUES (11, -3, -3, 'A', 1);
INSERT INTO urano_bloque_pagina VALUES (12, -3, -5, 'C', 1);
INSERT INTO urano_bloque_pagina VALUES (13, -4, -1, 'B', 1);
INSERT INTO urano_bloque_pagina VALUES (14, -4, -2, 'E', 1);
INSERT INTO urano_bloque_pagina VALUES (15, -4, -3, 'A', 1);
INSERT INTO urano_bloque_pagina VALUES (16, -4, -9, 'C', 1);
INSERT INTO urano_bloque_pagina VALUES (17, -5, -1, 'B', 1);
INSERT INTO urano_bloque_pagina VALUES (18, -5, -2, 'E', 1);
INSERT INTO urano_bloque_pagina VALUES (19, -5, -3, 'A', 1);
INSERT INTO urano_bloque_pagina VALUES (20, -5, -6, 'C', 1);
INSERT INTO urano_bloque_pagina VALUES (21, -6, -1, 'B', 1);
INSERT INTO urano_bloque_pagina VALUES (22, -6, -2, 'E', 1);
INSERT INTO urano_bloque_pagina VALUES (23, -6, -3, 'A', 1);
INSERT INTO urano_bloque_pagina VALUES (24, -6, -7, 'C', 1);
INSERT INTO urano_bloque_pagina VALUES (25, -7, -1, 'B', 1);
INSERT INTO urano_bloque_pagina VALUES (26, -7, -2, 'E', 1);
INSERT INTO urano_bloque_pagina VALUES (27, -7, -3, 'A', 1);
INSERT INTO urano_bloque_pagina VALUES (28, -7, -10, 'C', 1);
INSERT INTO urano_bloque_pagina VALUES (29, -8, -1, 'B', 1);
INSERT INTO urano_bloque_pagina VALUES (30, -8, -2, 'E', 1);
INSERT INTO urano_bloque_pagina VALUES (31, -8, -3, 'A', 1);
INSERT INTO urano_bloque_pagina VALUES (32, -8, -11, 'C', 1);
INSERT INTO urano_bloque_pagina VALUES (33, -9, -1, 'B', 1);
INSERT INTO urano_bloque_pagina VALUES (34, -9, -2, 'E', 1);
INSERT INTO urano_bloque_pagina VALUES (35, -9, -3, 'A', 1);
INSERT INTO urano_bloque_pagina VALUES (36, -9, -12, 'C', 1);
INSERT INTO urano_bloque_pagina VALUES (37, 1, 1, 'C', 1);
INSERT INTO urano_bloque_pagina VALUES (41, 4, 5, 'C', 1);
INSERT INTO urano_bloque_pagina VALUES (38, 2, 3, 'C', 1);
INSERT INTO urano_bloque_pagina VALUES (43, 3, 2, 'A', 1);
INSERT INTO urano_bloque_pagina VALUES (44, 3, 4, 'E', 1);
INSERT INTO urano_bloque_pagina VALUES (45, 3, 6, 'C', 1);


--
-- TOC entry 3112 (class 0 OID 0)
-- Dependencies: 171
-- Name: urano_bloque_pagina_idrelacion_seq; Type: SEQUENCE SET; Schema: public; Owner: usuariourano
--

SELECT pg_catalog.setval('urano_bloque_pagina_idrelacion_seq', 45, true);


--
-- TOC entry 3014 (class 0 OID 132490)
-- Dependencies: 174
-- Data for Name: urano_configuracion; Type: TABLE DATA; Schema: public; Owner: usuariourano
--

INSERT INTO urano_configuracion VALUES (1, 'dbesquema                                                                                                                                                                                                                                                      ', 'public                                                                                                                                                                                                                                                         ');
INSERT INTO urano_configuracion VALUES (2, 'prefijo                                                                                                                                                                                                                                                        ', 'urano_                                                                                                                                                                                                                                                         ');
INSERT INTO urano_configuracion VALUES (3, 'nombreAplicativo                                                                                                                                                                                                                                               ', 'Sistema de Gestión Académica                                                                                                                                                                                                                                   ');
INSERT INTO urano_configuracion VALUES (4, 'raizDocumento                                                                                                                                                                                                                                                  ', '/usr/local/apache/htdocs/urano                                                                                                                                                                                                                                 ');
INSERT INTO urano_configuracion VALUES (5, 'host                                                                                                                                                                                                                                                           ', 'http://10.20.0.38                                                                                                                                                                                                                                              ');
INSERT INTO urano_configuracion VALUES (6, 'site                                                                                                                                                                                                                                                           ', '/urano                                                                                                                                                                                                                                                         ');
INSERT INTO urano_configuracion VALUES (7, 'nombreAdministrador                                                                                                                                                                                                                                            ', 'administrador                                                                                                                                                                                                                                                  ');
INSERT INTO urano_configuracion VALUES (8, 'claveAdministrador                                                                                                                                                                                                                                             ', 'yDObloxv6yGRBU2fvG00cOsRp1sEETXzU95rpENwya0                                                                                                                                                                                                                    ');
INSERT INTO urano_configuracion VALUES (9, 'correoAdministrador                                                                                                                                                                                                                                            ', 'computo@udistrital.edu.co                                                                                                                                                                                                                                      ');
INSERT INTO urano_configuracion VALUES (10, 'enlace                                                                                                                                                                                                                                                         ', 'data                                                                                                                                                                                                                                                           ');
INSERT INTO urano_configuracion VALUES (11, 'estiloPredeterminado                                                                                                                                                                                                                                           ', 'cupertino                                                                                                                                                                                                                                                      ');
INSERT INTO urano_configuracion VALUES (12, 'moduloDesarrollo                                                                                                                                                                                                                                               ', 'moduloDesarrollo                                                                                                                                                                                                                                               ');
INSERT INTO urano_configuracion VALUES (13, 'googlemaps                                                                                                                                                                                                                                                     ', '                                                                                                                                                                                                                                                               ');
INSERT INTO urano_configuracion VALUES (14, 'recatchapublica                                                                                                                                                                                                                                                ', '                                                                                                                                                                                                                                                               ');
INSERT INTO urano_configuracion VALUES (15, 'recatchaprivada                                                                                                                                                                                                                                                ', '                                                                                                                                                                                                                                                               ');
INSERT INTO urano_configuracion VALUES (16, 'expiracion                                                                                                                                                                                                                                                     ', '60                                                                                                                                                                                                                                                             ');
INSERT INTO urano_configuracion VALUES (17, 'instalado                                                                                                                                                                                                                                                      ', 'true                                                                                                                                                                                                                                                           ');
INSERT INTO urano_configuracion VALUES (18, 'debugMode                                                                                                                                                                                                                                                      ', 'false                                                                                                                                                                                                                                                          ');
INSERT INTO urano_configuracion VALUES (19, 'dbPrincipal                                                                                                                                                                                                                                                    ', 'urano                                                                                                                                                                                                                                                          ');
INSERT INTO urano_configuracion VALUES (20, 'hostSeguro                                                                                                                                                                                                                                                     ', 'https://10.20.0.38                                                                                                                                                                                                                                             ');


--
-- TOC entry 3113 (class 0 OID 0)
-- Dependencies: 173
-- Name: urano_configuracion_id_parametro_seq; Type: SEQUENCE SET; Schema: public; Owner: usuariourano
--

SELECT pg_catalog.setval('urano_configuracion_id_parametro_seq', 20, true);


--
-- TOC entry 3016 (class 0 OID 132501)
-- Dependencies: 176
-- Data for Name: urano_dbms; Type: TABLE DATA; Schema: public; Owner: usuariourano
--

INSERT INTO urano_dbms VALUES (1, 'estructura', 'pgsql', '10.20.0.38', 5432, '', 'urano', 'public', 'usuariourano', 'yDObloxv6yGRBU2fvG00cOsRp1sEETXzU95rpENwya0');
INSERT INTO urano_dbms VALUES (2, 'academica', 'oci8', '10.20.0.36', 1521, '', 'SUDD', 'mntac', 'snies', 'm-sR5ImpbFUeODq7knOOrMYFJZQ5re0-nx4rXCuuRoo
');


--
-- TOC entry 3114 (class 0 OID 0)
-- Dependencies: 175
-- Name: urano_dbms_idconexion_seq; Type: SEQUENCE SET; Schema: public; Owner: usuariourano
--

SELECT pg_catalog.setval('urano_dbms_idconexion_seq', 1, true);


--
-- TOC entry 3046 (class 0 OID 136085)
-- Dependencies: 206
-- Data for Name: urano_enlace; Type: TABLE DATA; Schema: public; Owner: usuariourano
--

INSERT INTO urano_enlace VALUES (1, NULL, 'actualizar_datos', 'Actualizar mis Datos', 'Este enlace aparece en el menú Docentes', '/appserv/docentes/doc_actualiza_dat.php', '', '');
INSERT INTO urano_enlace VALUES (4, 2, 'captura_notas', 'Captura de Notas', 'Este enlace aparece en el menú Docentes abarca notas pregrado y postgrado', '', 'registro_notasDocente', 'usuario=$usuario&action=loginCondor&nivel=PREGRADO&tipoUser=30&modulo=docentes&tiempo=300');
INSERT INTO urano_enlace VALUES (5, NULL, 'vacacionales', 'Vacacionales', 'Este enlace aparece en el menú Docentes', '/appserv/docentes/doc_carga_curvac.php', '', '');
INSERT INTO urano_enlace VALUES (6, 3, 'envio_correos', 'Envío de Correos', 'Este enlace aparece en el menú Docentes', '', 'docentes', 'indexEvaluacion&usuario=$usuario&tipo=30&token=$tokenSaraAcademica&opcionPagina=listaClase');
INSERT INTO urano_enlace VALUES (7, 2, 'notas_periodo_anterior', 'Notas Periodo Anterior', 'Este enlace aparece en el menú Docentes', '', 'registro_notasDocente', 'usuario=$usuario&opcion=notasPerAnterior&nivel=ANTERIOR&tipoUser=30&aplicacion=Condor&modulo=docentes&tiempo=300');
INSERT INTO urano_enlace VALUES (8, 3, 'autoevaluacion', 'Auto Evaluación', 'Este enlace aparece en el menú Docentes', '', 'docentes', 'indexEvaluacion&usuario=$usuario&tipo=30&token=$tokenSaraAcademica&opcionPagina=indexEvaluacion');
INSERT INTO urano_enlace VALUES (9, NULL, 'observaciones_estudiantes', 'Observaciones de Estudiantes', 'Este enlace aparece en el menú Docentes', '/appserv/docentes/doc_obsevaciones.php', '', '');
INSERT INTO urano_enlace VALUES (10, 3, 'resultados_evaluacion', 'Resultados Evaluación', 'Este enlace aparece en el menú Docentes', '', 'docentes', 'indexEvaluacion&usuario=$usuario&tipo=30&token=$tokenSaraAcademica&opcionPagina=resultadosEvaluacion');
INSERT INTO urano_enlace VALUES (11, 1, 'consejerias', 'Estudiantes aconsejados', 'Este enlace aparece en el menú Docentes', '', 'admin_consejeriasDocente', 'usuario=$usuario&opcion=verProyectos&tipoUser=30&modulo=Docente&aplicacion=Condor');
INSERT INTO urano_enlace VALUES (12, 2, 'plan_trabajo', 'Plan de Trabajo', 'Este enlace aparece en el menú Docentes', '', 'registro_plan_trabajo', 'usuario=$usuario&action=loginCondor&nivel=A&tipoUser=30&modulo=planTrabajo&tiempo=300');
INSERT INTO urano_enlace VALUES (13, 6, 'certificados de ingresos', 'Certificado de Ingresos y Retenciones', 'Este enlace aparece en el menú Docentes', '', 'certificaciones', 'gestionPassword&usuario=$usuario&tipo=30&token=$tokenSaraAdministrativa&opcionPagina=gestionAdministrativos');
INSERT INTO urano_enlace VALUES (14, 5, 'produccion_academica', 'Producción Académica', 'Este enlace aparece en el menú Docentes', '', 'estadoDeCuentaCondor', 'docente=$usuario&expiracion=$tiempo');
INSERT INTO urano_enlace VALUES (15, 1, 'documentos', 'Documentos', 'Este enlace aparece en el menú Docentes - Desprendibles de pago e histórico de vinculaciones', '', 'adminDocumentosVinculacion', 'usuario=$usuario&action=loginCondor&opcion=inicio&tipoUser=30&nivel=A&modulo=Docente&aplicacion=Condor&tiempo=300');
INSERT INTO urano_enlace VALUES (16, 4, 'inventario_docente', 'Inventario Docente', 'Este enlace aparece en el menú Docentes', '', 'inventarioFuncionario', 'actionBloque=inventarioFuncionario&bloqueGrupo=inventarios/gestionElementos&bloque=funcionarioElemento&opcion=Consultar&identificacion=$usuario&usuario=$usuario&accesoCondor=true');
INSERT INTO urano_enlace VALUES (17, 4, 'asignacion_inventarios_contratistas', 'Asignación de Inventarios a Contratistas', 'Este enlace aparece en el menú Docentes', '', 'AsignacionInventariosContratista', 'actionBloque=AsignacionInventariosContratista&bloqueGrupo=inventarios/asignarInventarioC&bloque=asignarInventario&identificacion=$usuario&usuario=$usuario&accesoCondor=true');
INSERT INTO urano_enlace VALUES (18, 4, 'consulta_asignacion_inventarios_contratistas', 'Consulta de Inventarios a Contratistas', 'Este enlace aparece en el menú Docentes', '', 'ConsultarInventariosContratistas', 'actionBloque=ConsultarInventariosContratistas&bloqueGrupo=inventarios/asignarInventarioC&bloque=consultarAsignacion&identificacion=$usuario&usuario=$usuario&accesoCondor=true');
INSERT INTO urano_enlace VALUES (19, 4, 'descarga_inventarios_contratistas', 'Descarga de Inventarios de Contratistas', 'Este enlace aparece en el menú Docentes', '', 'DescargarInventarioContratista', 'actionBloque=DescargarInventarioContratista&bloqueGrupo=inventarios/asignarInventarioC&bloque=descargarInventario&identificacion=$usuario&usuario=$usuario&accesoCondor=true');
INSERT INTO urano_enlace VALUES (20, 4, 'paz_y_salvo_inventarios_contratistas', 'Paz y Salvo de Inventarios de Contratistas', 'Este enlace aparece en el menú Docentes', '', 'PazSalvoContratista', 'actionBloque=PazSalvoContratista&bloqueGrupo=inventarios/asignarInventarioC&bloque=generarPazSalvo&identificacion=$usuario&usuario=$usuario&accesoCondor=true');
INSERT INTO urano_enlace VALUES (3, NULL, 'lista_clase', 'Lista de clase', 'Este enlace aparece en el menú Docentes', '/appserv/docentes/doc_curso.php', '', '');
INSERT INTO urano_enlace VALUES (2, NULL, 'asignaturas', 'Horario', 'Este enlace aparece en el menú Docentes', '/appserv/docentes/doc_fre_carga.php', '', '');


--
-- TOC entry 3115 (class 0 OID 0)
-- Dependencies: 205
-- Name: urano_enlace_id_enlace_seq; Type: SEQUENCE SET; Schema: public; Owner: usuariourano
--

SELECT pg_catalog.setval('urano_enlace_id_enlace_seq', 1, true);


--
-- TOC entry 3017 (class 0 OID 132510)
-- Dependencies: 177
-- Data for Name: urano_estilo; Type: TABLE DATA; Schema: public; Owner: usuariourano
--



--
-- TOC entry 3044 (class 0 OID 136071)
-- Dependencies: 204
-- Data for Name: urano_grupo_menu; Type: TABLE DATA; Schema: public; Owner: usuariourano
--

INSERT INTO urano_grupo_menu VALUES (4, 3, 'consejerias', 'Consejerías', 'Perteneciente al menú Docente', true, NULL, 5);
INSERT INTO urano_grupo_menu VALUES (6, 3, 'inventario', 'Inventario', 'Perteneciente al menú Docente', true, NULL, 1);
INSERT INTO urano_grupo_menu VALUES (2, 3, 'cursos', 'Cursos', 'Perteneciente al menú Docente', true, NULL, 2);
INSERT INTO urano_grupo_menu VALUES (3, 3, 'evaluacion docente', 'Evaluación Docente', 'Perteneciente al menú Docente', true, NULL, 4);
INSERT INTO urano_grupo_menu VALUES (5, 3, 'vinculacion', 'Vinculación Docente', 'Perteneciente al menú Docente', true, NULL, 3);


--
-- TOC entry 3116 (class 0 OID 0)
-- Dependencies: 203
-- Name: urano_grupo_menu_id_grupo_menu_seq; Type: SEQUENCE SET; Schema: public; Owner: usuariourano
--

SELECT pg_catalog.setval('urano_grupo_menu_id_grupo_menu_seq', 2, true);


--
-- TOC entry 3019 (class 0 OID 132518)
-- Dependencies: 179
-- Data for Name: urano_logger; Type: TABLE DATA; Schema: public; Owner: usuariourano
--



--
-- TOC entry 3117 (class 0 OID 0)
-- Dependencies: 178
-- Name: urano_logger_id_seq; Type: SEQUENCE SET; Schema: public; Owner: usuariourano
--

SELECT pg_catalog.setval('urano_logger_id_seq', 1, false);


--
-- TOC entry 3042 (class 0 OID 136059)
-- Dependencies: 202
-- Data for Name: urano_menu; Type: TABLE DATA; Schema: public; Owner: usuariourano
--

INSERT INTO urano_menu VALUES (3, 'docente', 'Docente', 'En este menú se muestran los servicios del docente', true, NULL);


--
-- TOC entry 3118 (class 0 OID 0)
-- Dependencies: 201
-- Name: urano_menu_id_menu_seq; Type: SEQUENCE SET; Schema: public; Owner: usuariourano
--

SELECT pg_catalog.setval('urano_menu_id_menu_seq', 1, false);


--
-- TOC entry 3021 (class 0 OID 132524)
-- Dependencies: 181
-- Data for Name: urano_pagina; Type: TABLE DATA; Schema: public; Owner: usuariourano
--

INSERT INTO urano_pagina VALUES (-1, 'development                                       ', 'Index módulo de desarrollo.                                                                                                                                                                                                                               ', 'development                                       ', 0, 'jquery=true&jquery-ui=true&jquery-validation=true                                                                                                                                                                                                              ');
INSERT INTO urano_pagina VALUES (-2, 'cruder                                            ', 'Generador módulos CRUD.                                                                                                                                                                                                                                   ', 'development                                       ', 0, 'jquery=true&jquery-ui=true&jquery-validation=true                                                                                                                                                                                                              ');
INSERT INTO urano_pagina VALUES (-3, 'desenlace                                         ', 'Analizar enlaces.                                                                                                                                                                                                                                         ', 'development                                       ', 0, 'jquery=true&jquery-ui=true&jquery-validation=true                                                                                                                                                                                                              ');
INSERT INTO urano_pagina VALUES (-4, 'codificador                                       ', 'Codificar/decodificar cadenas.                                                                                                                                                                                                                            ', 'development                                       ', 0, 'jquery=true&jquery-ui=true&jquery-validation=true                                                                                                                                                                                                              ');
INSERT INTO urano_pagina VALUES (-5, 'registro                                          ', 'Registrar páginas o módulos.                                                                                                                                                                                                                              ', 'development                                       ', 0, 'jquery=true&jquery-ui=true&jquery-validation=true                                                                                                                                                                                                              ');
INSERT INTO urano_pagina VALUES (-6, 'constructor                                       ', 'Diseñar páginas.                                                                                                                                                                                                                                          ', 'development                                       ', 0, 'jquery=true&jquery-ui=true&jquery-validation=true                                                                                                                                                                                                              ');
INSERT INTO urano_pagina VALUES (-7, 'plugin                                            ', 'Agregar plugin preconfigurados.                                                                                                                                                                                                                           ', 'development                                       ', 0, 'jquery=true&jquery-ui=true&jquery-validation=true                                                                                                                                                                                                              ');
INSERT INTO urano_pagina VALUES (-8, 'saraFormCreator                                   ', 'Módulo SARA form creator.                                                                                                                                                                                                                                 ', 'development                                       ', 0, 'jquery=true&jquery-ui=true&jquery-validation=true                                                                                                                                                                                                              ');
INSERT INTO urano_pagina VALUES (-9, 'formatearSQL                                      ', 'Módulo Formatear/Desformatear SQL.                                                                                                                                                                                                                        ', 'development                                       ', 0, 'jquery=true&jquery-ui=true&jquery-validation=true                                                                                                                                                                                                              ');
INSERT INTO urano_pagina VALUES (1, 'index                                             ', 'Index del sitio general.                                                                                                                                                                                                                                  ', '                                                  ', 0, 'jquery=true                                                                                                                                                                                                                                                    ');
INSERT INTO urano_pagina VALUES (2, 'home                                              ', 'Se muestran los frames de los Servicios de noticias y demás                                                                                                                                                                                               ', '                                                  ', 0, 'jquery=2.1.4.min&bootstrap=3.3.5.min                                                                                                                                                                                                                           ');
INSERT INTO urano_pagina VALUES (4, 'horario                                           ', 'horario                                                                                                                                                                                                                                                   ', '                                                  ', 0, 'jquery=true&jquery-ui=true&jquery-validation=true                                                                                                                                                                                                              ');
INSERT INTO urano_pagina VALUES (3, 'bienvenido                                        ', 'En este se unen Menú, Bloque C y Pie de Página                                                                                                                                                                                                            ', '                                                  ', 0, 'jquery=2.1.4.min&bootstrap=3.3.5.min                                                                                                                                                                                                                           ');


--
-- TOC entry 3119 (class 0 OID 0)
-- Dependencies: 180
-- Name: urano_pagina_id_pagina_seq; Type: SEQUENCE SET; Schema: public; Owner: usuariourano
--

SELECT pg_catalog.setval('urano_pagina_id_pagina_seq', 7, true);


--
-- TOC entry 3040 (class 0 OID 136050)
-- Dependencies: 200
-- Data for Name: urano_rol; Type: TABLE DATA; Schema: public; Owner: usuariourano
--

INSERT INTO urano_rol VALUES (4, 'COORDINADOR', 'COORDINADOR', 'CONSULTAR, MODIFICAR, INSERTAR Y BORRAR.', true, '2016-03-18');
INSERT INTO urano_rol VALUES (16, 'DECANO', 'DECANO', 'CONSULTAR ACADEMICA. CONSULTAR MODIFICAR E INSERTAR EN EVALUACION DOCENTE', true, '2016-03-18');
INSERT INTO urano_rol VALUES (20, 'ADMINISTRACION OAS', 'ADMINISTRACION OAS', 'CONSULTAR, MODIFICAR, INSERTAR Y BORRAR DATOS PARA PRUEBAS Y MANTENIMIENTO', true, '2016-03-18');
INSERT INTO urano_rol VALUES (24, 'FUNCIONARIO', 'FUNCIONARIO', 'CONSULTAR INFORMACION DE NOMINA', true, '2016-03-18');
INSERT INTO urano_rol VALUES (28, 'COORDINADOR CREDITOS', 'COORDINADOR CREDITOS', 'CONSULTAR, MODIFICAR, INSERTAR Y BORRAR.', true, '2016-03-18');
INSERT INTO urano_rol VALUES (30, 'DOCENTE', 'DOCENTE', 'CONSULTAR, MODIFICAR, INSERTAR Y BORRAR NOTAS', true, '2016-03-18');
INSERT INTO urano_rol VALUES (31, 'RECTOR', 'RECTOR', 'CONSULTAR INFORMACION ACADEMICA Y GENERAL', true, '2016-03-18');
INSERT INTO urano_rol VALUES (32, 'VICERRECTOR', 'VICERRECTOR', 'CONSULTAR INFORMACION ACADEMICA Y GENERAL', true, '2016-03-18');
INSERT INTO urano_rol VALUES (33, 'ADMISIONES REGISTRO', 'ADMISIONES REGISTRO', 'PROCESOS DE LA OFICINA DE REGISTRO Y CONTROL POR LA WEB', true, '2016-03-18');
INSERT INTO urano_rol VALUES (34, 'ASESOR', 'ASESOR', 'CONSULTAR INFORMACION ACADEMICA Y GENERAL', true, '2016-03-18');
INSERT INTO urano_rol VALUES (51, 'ESTUDIANTE', 'ESTUDIANTE', 'CONSULTAR SUS PROPIOS DATOS', true, '2016-03-18');
INSERT INTO urano_rol VALUES (52, 'ESTUDIANTE CREDITOS', 'ESTUDIANTE CREDITOS', 'CONSULTAR SUS PROPIOS DATOS', true, '2016-03-18');
INSERT INTO urano_rol VALUES (61, 'ASESOR DE VICERRECTO', 'ASESOR DE VICERRECTO', 'ACCESO DESDE VICERRECTORIA AL SISTEMA DE GESTION ACADEMICA', true, '2016-03-18');
INSERT INTO urano_rol VALUES (68, 'BIENESTAR INSTITUC.', 'BIENESTAR INSTITUC.', 'CALENDARIO', true, '2016-03-18');
INSERT INTO urano_rol VALUES (72, 'DIV.RECURSOS HUMANOS', 'DIV.RECURSOS HUMANOS', 'CALENDARIO', true, '2016-03-18');
INSERT INTO urano_rol VALUES (75, 'ADMINISTRADOR SGA', 'ADMINISTRADOR SGA', 'ACCESO DESDE CONDOR PARA ADMINISTRACION SISTEMA DE GESTION ACADEMICA', true, '2016-03-18');
INSERT INTO urano_rol VALUES (80, 'SOPORTE OAS', 'SOPORTE OAS', 'SOPORTE USUARIOS - CLAVE', true, '2016-03-18');
INSERT INTO urano_rol VALUES (83, 'SEC ACADEMICO', 'SEC ACADEMICO', 'CONSULTAR, MODIFICAR, INSERTAR Y BORRAR DATOS ESTUDIANTES Y RECIBOS DE PAGO', true, '2016-03-18');
INSERT INTO urano_rol VALUES (84, 'DESARROLLO OAS', 'DESARROLLO OAS', 'REGISTRAR, CONSULTAR Y MODIFICAR NOVEDADES EN LA DOCUMENTACION DE LAS APLICACIONES OAS', true, '2016-03-18');
INSERT INTO urano_rol VALUES (87, 'ADMINSTRADOR MOODLE', 'ADMINSTRADOR MOODLE', 'CONSULTAR', true, '2016-03-18');
INSERT INTO urano_rol VALUES (88, 'ADM DOCENCIA', 'ADM DOCENCIA', 'CONSULTAR, MODIFICAR, INSERTAR DATOS DE DOCENCIA', true, '2016-03-18');
INSERT INTO urano_rol VALUES (104, 'ASPU', 'ASPU', 'CONSULTA INFORMACION DOCENTES', true, '2016-03-18');
INSERT INTO urano_rol VALUES (105, 'PLANEACION', 'PLANEACION', 'GESTIONAR SEDES, EDIFICIOS Y ESPACIOS FISICOS ACADEMICOS; CONSULTAR FACULTADES', true, '2016-03-18');
INSERT INTO urano_rol VALUES (109, 'ASIST. CONTABILIDAD', 'ASIST. CONTABILIDAD', 'CONSULTA RECIBOS DE PAGO', true, '2016-03-18');
INSERT INTO urano_rol VALUES (110, 'ASISTENTE PROYECTO', 'ASISTENTE PROYECTO', 'CONSULTAR', true, '2016-03-18');
INSERT INTO urano_rol VALUES (111, 'ASISTENTE FACULTAD', 'ASISTENTE FACULTAD', 'CONSULTAR', true, '2016-03-18');
INSERT INTO urano_rol VALUES (112, 'ASISTENTE SEC. FAC.', 'ASISTENTE SEC. FAC.', 'CONSULTAR', true, '2016-03-18');
INSERT INTO urano_rol VALUES (113, 'SEC. GENERAL', 'SEC. GENERAL', 'CONSULTAR', true, '2016-03-18');
INSERT INTO urano_rol VALUES (114, 'SECRET. PROYECTO', 'SECRET. PROYECTO', 'CONSULTAR', true, '2016-03-18');
INSERT INTO urano_rol VALUES (116, 'SECRET. SEC. ACAD.', 'SECRET. SEC. ACAD.', 'CONSULTAR', true, '2016-03-18');
INSERT INTO urano_rol VALUES (117, 'ASIST.REL. INTER.', 'ASIST.REL. INTER.', 'CONSULTAR', true, '2016-03-18');
INSERT INTO urano_rol VALUES (118, 'LABORATORIOS', 'LABORATORIOS', 'CONSULTAR', true, '2016-03-18');
INSERT INTO urano_rol VALUES (119, 'ASISTENTE ILUD', 'ASISTENTE ILUD', 'CONSULTAR', true, '2016-03-18');
INSERT INTO urano_rol VALUES (120, 'CONSULTOR', 'CONSULTOR', 'CONSULTAR', true, '2016-03-18');
INSERT INTO urano_rol VALUES (121, 'EGRESADO', 'EGRESADO', 'CONSULTAR', true, '2016-03-18');
INSERT INTO urano_rol VALUES (122, 'ASISTENTE TESORERIA', 'ASISTENTE TESORERIA', 'CONSULTAR', true, '2016-03-18');
INSERT INTO urano_rol VALUES (123, 'CONTRATISTA', 'CONTRATISTA', 'CONSULTAR, VERIFICAR', true, '2016-03-18');
INSERT INTO urano_rol VALUES (124, 'ASISTENTE DOCENCIA', 'ASISTENTE DOCENCIA', 'CONSULTAR, VERIFICAR', true, '2016-03-18');
INSERT INTO urano_rol VALUES (125, 'VOTO', 'VOTO', 'CONSULTAR', true, '2016-03-18');


--
-- TOC entry 3047 (class 0 OID 136102)
-- Dependencies: 207
-- Data for Name: urano_servicio; Type: TABLE DATA; Schema: public; Owner: usuariourano
--

INSERT INTO urano_servicio VALUES (30, 2, 2, '', true);
INSERT INTO urano_servicio VALUES (30, 2, 3, '', true);
INSERT INTO urano_servicio VALUES (30, 2, 4, '', true);
INSERT INTO urano_servicio VALUES (30, 2, 5, '', true);
INSERT INTO urano_servicio VALUES (30, 2, 6, '', true);
INSERT INTO urano_servicio VALUES (30, 2, 7, '', true);
INSERT INTO urano_servicio VALUES (30, 3, 8, '', true);
INSERT INTO urano_servicio VALUES (30, 3, 9, '', true);
INSERT INTO urano_servicio VALUES (30, 3, 10, '', true);
INSERT INTO urano_servicio VALUES (30, 4, 11, '', true);
INSERT INTO urano_servicio VALUES (30, 5, 12, '', true);
INSERT INTO urano_servicio VALUES (30, 5, 13, '', true);
INSERT INTO urano_servicio VALUES (30, 5, 14, '', true);
INSERT INTO urano_servicio VALUES (30, 5, 15, '', true);
INSERT INTO urano_servicio VALUES (30, 6, 16, '', true);
INSERT INTO urano_servicio VALUES (30, 6, 17, '', true);
INSERT INTO urano_servicio VALUES (30, 6, 18, '', true);
INSERT INTO urano_servicio VALUES (30, 6, 19, '', true);
INSERT INTO urano_servicio VALUES (30, 6, 20, '', true);


--
-- TOC entry 3026 (class 0 OID 132565)
-- Dependencies: 186
-- Data for Name: urano_subsistema; Type: TABLE DATA; Schema: public; Owner: usuariourano
--



--
-- TOC entry 3120 (class 0 OID 0)
-- Dependencies: 185
-- Name: urano_subsistema_id_subsistema_seq; Type: SEQUENCE SET; Schema: public; Owner: usuariourano
--

SELECT pg_catalog.setval('urano_subsistema_id_subsistema_seq', 1, false);


--
-- TOC entry 3039 (class 0 OID 136039)
-- Dependencies: 199
-- Data for Name: urano_subsistema_sga; Type: TABLE DATA; Schema: public; Owner: usuariourano
--

INSERT INTO urano_subsistema_sga VALUES (1, 'academicopro', 'http://10.20.0.38', '/academicopro/index.php', true, 'index', 'codificar_url_appserv');
INSERT INTO urano_subsistema_sga VALUES (2, 'weboffice', 'http://10.20.0.38', '/weboffice/index.php', true, 'index', 'codificar_url_appserv');
INSERT INTO urano_subsistema_sga VALUES (3, 'saraacademica', 'http://10.20.0.38', '/saraacademica/index.php', true, 'temasys', 'codificar_saraacademica');
INSERT INTO urano_subsistema_sga VALUES (4, 'arka', 'http://10.20.0.38', '/arka/index.php', true, 'data', 'codificar_arka');
INSERT INTO urano_subsistema_sga VALUES (5, 'kyron', 'http://10.20.0.38', '/kyron/index.php', true, 'data', 'codificar_kyron');
INSERT INTO urano_subsistema_sga VALUES (6, 'saraadministrativa', 'http://10.20.0.38', '/saraadministrativa/index.php', true, 'temasys', 'codificar_saraacademica');
INSERT INTO urano_subsistema_sga VALUES (7, 'lamasu', 'http://10.20.0.38', '/lamasu/index.php', true, 'temasys', 'codificar_saraacademica');


--
-- TOC entry 3027 (class 0 OID 132575)
-- Dependencies: 187
-- Data for Name: urano_tempformulario; Type: TABLE DATA; Schema: public; Owner: usuariourano
--



--
-- TOC entry 3023 (class 0 OID 132539)
-- Dependencies: 183
-- Data for Name: urano_usuario; Type: TABLE DATA; Schema: public; Owner: usuariourano
--



--
-- TOC entry 3121 (class 0 OID 0)
-- Dependencies: 182
-- Name: urano_usuario_id_usuario_seq; Type: SEQUENCE SET; Schema: public; Owner: usuariourano
--

SELECT pg_catalog.setval('urano_usuario_id_usuario_seq', 1, false);


--
-- TOC entry 3024 (class 0 OID 132557)
-- Dependencies: 184
-- Data for Name: urano_usuario_subsistema; Type: TABLE DATA; Schema: public; Owner: usuariourano
--



--
-- TOC entry 3028 (class 0 OID 132581)
-- Dependencies: 188
-- Data for Name: urano_valor_sesion; Type: TABLE DATA; Schema: public; Owner: usuariourano
--



SET search_path = general, pg_catalog;

--
-- TOC entry 2873 (class 2606 OID 135879)
-- Name: est_notifi_pkey; Type: CONSTRAINT; Schema: general; Owner: usuariourano; Tablespace: 
--

ALTER TABLE ONLY est_notifi
    ADD CONSTRAINT est_notifi_pkey PRIMARY KEY (id_estado);


--
-- TOC entry 2871 (class 2606 OID 135869)
-- Name: estados_pkey; Type: CONSTRAINT; Schema: general; Owner: usuariourano; Tablespace: 
--

ALTER TABLE ONLY est_noti
    ADD CONSTRAINT estados_pkey PRIMARY KEY (id_estado);


--
-- TOC entry 2879 (class 2606 OID 136005)
-- Name: noticias_pkey; Type: CONSTRAINT; Schema: general; Owner: usuariourano; Tablespace: 
--

ALTER TABLE ONLY noticia
    ADD CONSTRAINT noticias_pkey PRIMARY KEY (id_noticia);


--
-- TOC entry 2881 (class 2606 OID 136025)
-- Name: notificacion_pkey; Type: CONSTRAINT; Schema: general; Owner: usuariourano; Tablespace: 
--

ALTER TABLE ONLY notificacion
    ADD CONSTRAINT notificacion_pkey PRIMARY KEY (id_notifi);


--
-- TOC entry 2875 (class 2606 OID 135963)
-- Name: tipo_noticia_pkey; Type: CONSTRAINT; Schema: general; Owner: usuariourano; Tablespace: 
--

ALTER TABLE ONLY tipo_noticia
    ADD CONSTRAINT tipo_noticia_pkey PRIMARY KEY (id_tipo);


--
-- TOC entry 2877 (class 2606 OID 135975)
-- Name: tipo_notifi_pkey; Type: CONSTRAINT; Schema: general; Owner: usuariourano; Tablespace: 
--

ALTER TABLE ONLY tipo_notifi
    ADD CONSTRAINT tipo_notifi_pkey PRIMARY KEY (id_tipo);


SET search_path = public, pg_catalog;

--
-- TOC entry 2855 (class 2606 OID 132487)
-- Name: urano_bloque_pagina_pkey; Type: CONSTRAINT; Schema: public; Owner: usuariourano; Tablespace: 
--

ALTER TABLE ONLY urano_bloque_pagina
    ADD CONSTRAINT urano_bloque_pagina_pkey PRIMARY KEY (idrelacion);


--
-- TOC entry 2853 (class 2606 OID 132476)
-- Name: urano_bloque_pkey; Type: CONSTRAINT; Schema: public; Owner: usuariourano; Tablespace: 
--

ALTER TABLE ONLY urano_bloque
    ADD CONSTRAINT urano_bloque_pkey PRIMARY KEY (id_bloque);


--
-- TOC entry 2857 (class 2606 OID 132498)
-- Name: urano_configuracion_pkey; Type: CONSTRAINT; Schema: public; Owner: usuariourano; Tablespace: 
--

ALTER TABLE ONLY urano_configuracion
    ADD CONSTRAINT urano_configuracion_pkey PRIMARY KEY (id_parametro);


--
-- TOC entry 2859 (class 2606 OID 132509)
-- Name: urano_dbms_pkey; Type: CONSTRAINT; Schema: public; Owner: usuariourano; Tablespace: 
--

ALTER TABLE ONLY urano_dbms
    ADD CONSTRAINT urano_dbms_pkey PRIMARY KEY (idconexion);


--
-- TOC entry 2891 (class 2606 OID 136093)
-- Name: urano_enlace_pkey; Type: CONSTRAINT; Schema: public; Owner: usuariourano; Tablespace: 
--

ALTER TABLE ONLY urano_enlace
    ADD CONSTRAINT urano_enlace_pkey PRIMARY KEY (id_enlace);


--
-- TOC entry 2861 (class 2606 OID 132515)
-- Name: urano_estilo_pkey; Type: CONSTRAINT; Schema: public; Owner: usuariourano; Tablespace: 
--

ALTER TABLE ONLY urano_estilo
    ADD CONSTRAINT urano_estilo_pkey PRIMARY KEY (usuario, estilo);


--
-- TOC entry 2889 (class 2606 OID 136077)
-- Name: urano_grupo_menu_pkey; Type: CONSTRAINT; Schema: public; Owner: usuariourano; Tablespace: 
--

ALTER TABLE ONLY urano_grupo_menu
    ADD CONSTRAINT urano_grupo_menu_pkey PRIMARY KEY (id_grupo_menu);


--
-- TOC entry 2887 (class 2606 OID 136068)
-- Name: urano_menu_pkey; Type: CONSTRAINT; Schema: public; Owner: usuariourano; Tablespace: 
--

ALTER TABLE ONLY urano_menu
    ADD CONSTRAINT urano_menu_pkey PRIMARY KEY (id_menu);


--
-- TOC entry 2863 (class 2606 OID 132536)
-- Name: urano_pagina_pkey; Type: CONSTRAINT; Schema: public; Owner: usuariourano; Tablespace: 
--

ALTER TABLE ONLY urano_pagina
    ADD CONSTRAINT urano_pagina_pkey PRIMARY KEY (id_pagina);


--
-- TOC entry 2885 (class 2606 OID 136056)
-- Name: urano_rol_pkey; Type: CONSTRAINT; Schema: public; Owner: usuariourano; Tablespace: 
--

ALTER TABLE ONLY urano_rol
    ADD CONSTRAINT urano_rol_pkey PRIMARY KEY (id_rol);


--
-- TOC entry 2893 (class 2606 OID 136107)
-- Name: urano_servicio_pkey; Type: CONSTRAINT; Schema: public; Owner: usuariourano; Tablespace: 
--

ALTER TABLE ONLY urano_servicio
    ADD CONSTRAINT urano_servicio_pkey PRIMARY KEY (id_rol, id_grupo_menu, id_enlace);


--
-- TOC entry 2867 (class 2606 OID 132574)
-- Name: urano_subsistema_pkey; Type: CONSTRAINT; Schema: public; Owner: usuariourano; Tablespace: 
--

ALTER TABLE ONLY urano_subsistema
    ADD CONSTRAINT urano_subsistema_pkey PRIMARY KEY (id_subsistema);


--
-- TOC entry 2883 (class 2606 OID 136043)
-- Name: urano_subsistema_sga_pkey; Type: CONSTRAINT; Schema: public; Owner: usuariourano; Tablespace: 
--

ALTER TABLE ONLY urano_subsistema_sga
    ADD CONSTRAINT urano_subsistema_sga_pkey PRIMARY KEY (id_subsistema_sga);


--
-- TOC entry 2865 (class 2606 OID 132556)
-- Name: urano_usuario_pkey; Type: CONSTRAINT; Schema: public; Owner: usuariourano; Tablespace: 
--

ALTER TABLE ONLY urano_usuario
    ADD CONSTRAINT urano_usuario_pkey PRIMARY KEY (id_usuario);


--
-- TOC entry 2869 (class 2606 OID 132586)
-- Name: urano_valor_sesion_pkey; Type: CONSTRAINT; Schema: public; Owner: usuariourano; Tablespace: 
--

ALTER TABLE ONLY urano_valor_sesion
    ADD CONSTRAINT urano_valor_sesion_pkey PRIMARY KEY (sesionid, variable);


SET search_path = general, pg_catalog;

--
-- TOC entry 2894 (class 2606 OID 136006)
-- Name: noticias_estado_fkey; Type: FK CONSTRAINT; Schema: general; Owner: usuariourano
--

ALTER TABLE ONLY noticia
    ADD CONSTRAINT noticias_estado_fkey FOREIGN KEY (noti_estado) REFERENCES est_noti(id_estado);


--
-- TOC entry 2895 (class 2606 OID 136011)
-- Name: noticias_id_tipo_fkey; Type: FK CONSTRAINT; Schema: general; Owner: usuariourano
--

ALTER TABLE ONLY noticia
    ADD CONSTRAINT noticias_id_tipo_fkey FOREIGN KEY (noti_tipo) REFERENCES tipo_noticia(id_tipo);


--
-- TOC entry 2896 (class 2606 OID 136026)
-- Name: notificacion_notifi_estado_fkey; Type: FK CONSTRAINT; Schema: general; Owner: usuariourano
--

ALTER TABLE ONLY notificacion
    ADD CONSTRAINT notificacion_notifi_estado_fkey FOREIGN KEY (notifi_estado) REFERENCES est_notifi(id_estado);


--
-- TOC entry 2897 (class 2606 OID 136031)
-- Name: notificacion_notifi_tipo_fkey; Type: FK CONSTRAINT; Schema: general; Owner: usuariourano
--

ALTER TABLE ONLY notificacion
    ADD CONSTRAINT notificacion_notifi_tipo_fkey FOREIGN KEY (notifi_tipo) REFERENCES tipo_notifi(id_tipo);


SET search_path = public, pg_catalog;

--
-- TOC entry 2899 (class 2606 OID 136094)
-- Name: urano_enlace_id_subsistema_sga_fkey; Type: FK CONSTRAINT; Schema: public; Owner: usuariourano
--

ALTER TABLE ONLY urano_enlace
    ADD CONSTRAINT urano_enlace_id_subsistema_sga_fkey FOREIGN KEY (id_subsistema_sga) REFERENCES urano_subsistema_sga(id_subsistema_sga);


--
-- TOC entry 2898 (class 2606 OID 136078)
-- Name: urano_grupo_menu_id_menu_fkey; Type: FK CONSTRAINT; Schema: public; Owner: usuariourano
--

ALTER TABLE ONLY urano_grupo_menu
    ADD CONSTRAINT urano_grupo_menu_id_menu_fkey FOREIGN KEY (id_menu) REFERENCES urano_menu(id_menu);


--
-- TOC entry 2902 (class 2606 OID 136118)
-- Name: urano_servicio_id_enlace_fkey; Type: FK CONSTRAINT; Schema: public; Owner: usuariourano
--

ALTER TABLE ONLY urano_servicio
    ADD CONSTRAINT urano_servicio_id_enlace_fkey FOREIGN KEY (id_enlace) REFERENCES urano_enlace(id_enlace);


--
-- TOC entry 2901 (class 2606 OID 136113)
-- Name: urano_servicio_id_grupo_menu_fkey; Type: FK CONSTRAINT; Schema: public; Owner: usuariourano
--

ALTER TABLE ONLY urano_servicio
    ADD CONSTRAINT urano_servicio_id_grupo_menu_fkey FOREIGN KEY (id_grupo_menu) REFERENCES urano_grupo_menu(id_grupo_menu);


--
-- TOC entry 2900 (class 2606 OID 136108)
-- Name: urano_servicio_id_rol_fkey; Type: FK CONSTRAINT; Schema: public; Owner: usuariourano
--

ALTER TABLE ONLY urano_servicio
    ADD CONSTRAINT urano_servicio_id_rol_fkey FOREIGN KEY (id_rol) REFERENCES urano_rol(id_rol);


--
-- TOC entry 3054 (class 0 OID 0)
-- Dependencies: 6
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2016-03-30 10:43:08

--
-- PostgreSQL database dump complete
--

