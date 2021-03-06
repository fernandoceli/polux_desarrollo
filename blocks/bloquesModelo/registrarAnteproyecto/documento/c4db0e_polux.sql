PGDMP                         s            polux    9.4.4    9.4.4 Y    b           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                       false            c           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                       false            d           1262    16925    polux    DATABASE     �   CREATE DATABASE polux WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'Spanish_Spain.1252' LC_CTYPE = 'Spanish_Spain.1252';
    DROP DATABASE polux;
             postgres    false                        2615    2200    public    SCHEMA        CREATE SCHEMA public;
    DROP SCHEMA public;
             postgres    false            e           0    0    SCHEMA public    COMMENT     6   COMMENT ON SCHEMA public IS 'standard public schema';
                  postgres    false    5            f           0    0    public    ACL     �   REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;
                  postgres    false    5                        2615    17049    trabajosdegrado    SCHEMA        CREATE SCHEMA trabajosdegrado;
    DROP SCHEMA trabajosdegrado;
             postgres    false            �            3079    11855    plpgsql 	   EXTENSION     ?   CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;
    DROP EXTENSION plpgsql;
                  false            g           0    0    EXTENSION plpgsql    COMMENT     @   COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';
                       false    196            �            1259    17079    polux_bloque    TABLE     �   CREATE TABLE polux_bloque (
    id_bloque integer NOT NULL,
    nombre character(50) NOT NULL,
    descripcion character(255) DEFAULT NULL::bpchar,
    grupo character(200) NOT NULL
);
     DROP TABLE public.polux_bloque;
       public         postgres    false    5            �            1259    17077    polux_bloque_id_bloque_seq    SEQUENCE     |   CREATE SEQUENCE polux_bloque_id_bloque_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 1   DROP SEQUENCE public.polux_bloque_id_bloque_seq;
       public       postgres    false    5    177            h           0    0    polux_bloque_id_bloque_seq    SEQUENCE OWNED BY     K   ALTER SEQUENCE polux_bloque_id_bloque_seq OWNED BY polux_bloque.id_bloque;
            public       postgres    false    176            �            1259    17091    polux_bloque_pagina    TABLE     �   CREATE TABLE polux_bloque_pagina (
    idrelacion integer NOT NULL,
    id_pagina integer DEFAULT 0 NOT NULL,
    id_bloque integer DEFAULT 0 NOT NULL,
    seccion character(1) NOT NULL,
    posicion integer DEFAULT 0 NOT NULL
);
 '   DROP TABLE public.polux_bloque_pagina;
       public         postgres    false    5            �            1259    17089 "   polux_bloque_pagina_idrelacion_seq    SEQUENCE     �   CREATE SEQUENCE polux_bloque_pagina_idrelacion_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 9   DROP SEQUENCE public.polux_bloque_pagina_idrelacion_seq;
       public       postgres    false    5    179            i           0    0 "   polux_bloque_pagina_idrelacion_seq    SEQUENCE OWNED BY     [   ALTER SEQUENCE polux_bloque_pagina_idrelacion_seq OWNED BY polux_bloque_pagina.idrelacion;
            public       postgres    false    178            �            1259    17102    polux_configuracion    TABLE     �   CREATE TABLE polux_configuracion (
    id_parametro integer NOT NULL,
    parametro character(255) NOT NULL,
    valor character(255) NOT NULL
);
 '   DROP TABLE public.polux_configuracion;
       public         postgres    false    5            �            1259    17100 $   polux_configuracion_id_parametro_seq    SEQUENCE     �   CREATE SEQUENCE polux_configuracion_id_parametro_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ;   DROP SEQUENCE public.polux_configuracion_id_parametro_seq;
       public       postgres    false    181    5            j           0    0 $   polux_configuracion_id_parametro_seq    SEQUENCE OWNED BY     _   ALTER SEQUENCE polux_configuracion_id_parametro_seq OWNED BY polux_configuracion.id_parametro;
            public       postgres    false    180            �            1259    17113 
   polux_dbms    TABLE     �  CREATE TABLE polux_dbms (
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
    DROP TABLE public.polux_dbms;
       public         postgres    false    5            �            1259    17111    polux_dbms_idconexion_seq    SEQUENCE     {   CREATE SEQUENCE polux_dbms_idconexion_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 0   DROP SEQUENCE public.polux_dbms_idconexion_seq;
       public       postgres    false    183    5            k           0    0    polux_dbms_idconexion_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE polux_dbms_idconexion_seq OWNED BY polux_dbms.idconexion;
            public       postgres    false    182            �            1259    17122    polux_estilo    TABLE     y   CREATE TABLE polux_estilo (
    usuario character(50) DEFAULT '0'::bpchar NOT NULL,
    estilo character(50) NOT NULL
);
     DROP TABLE public.polux_estilo;
       public         postgres    false    5            �            1259    17130    polux_logger    TABLE     }   CREATE TABLE polux_logger (
    id integer NOT NULL,
    evento character(255) NOT NULL,
    fecha character(50) NOT NULL
);
     DROP TABLE public.polux_logger;
       public         postgres    false    5            �            1259    17128    polux_logger_id_seq    SEQUENCE     u   CREATE SEQUENCE polux_logger_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE public.polux_logger_id_seq;
       public       postgres    false    186    5            l           0    0    polux_logger_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE polux_logger_id_seq OWNED BY polux_logger.id;
            public       postgres    false    185            �            1259    17136    polux_pagina    TABLE     3  CREATE TABLE polux_pagina (
    id_pagina integer NOT NULL,
    nombre character(50) DEFAULT ''::bpchar NOT NULL,
    descripcion character(250) DEFAULT ''::bpchar NOT NULL,
    modulo character(50) DEFAULT ''::bpchar NOT NULL,
    nivel integer DEFAULT 0 NOT NULL,
    parametro character(255) NOT NULL
);
     DROP TABLE public.polux_pagina;
       public         postgres    false    5            �            1259    17134    polux_pagina_id_pagina_seq    SEQUENCE     |   CREATE SEQUENCE polux_pagina_id_pagina_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 1   DROP SEQUENCE public.polux_pagina_id_pagina_seq;
       public       postgres    false    188    5            m           0    0    polux_pagina_id_pagina_seq    SEQUENCE OWNED BY     K   ALTER SEQUENCE polux_pagina_id_pagina_seq OWNED BY polux_pagina.id_pagina;
            public       postgres    false    187            �            1259    17177    polux_subsistema    TABLE     �   CREATE TABLE polux_subsistema (
    id_subsistema integer NOT NULL,
    nombre character varying(250) NOT NULL,
    etiqueta character varying(100) NOT NULL,
    id_pagina integer DEFAULT 0 NOT NULL,
    observacion text
);
 $   DROP TABLE public.polux_subsistema;
       public         postgres    false    5            �            1259    17175 "   polux_subsistema_id_subsistema_seq    SEQUENCE     �   CREATE SEQUENCE polux_subsistema_id_subsistema_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 9   DROP SEQUENCE public.polux_subsistema_id_subsistema_seq;
       public       postgres    false    5    193            n           0    0 "   polux_subsistema_id_subsistema_seq    SEQUENCE OWNED BY     [   ALTER SEQUENCE polux_subsistema_id_subsistema_seq OWNED BY polux_subsistema.id_subsistema;
            public       postgres    false    192            �            1259    17187    polux_tempformulario    TABLE     �   CREATE TABLE polux_tempformulario (
    id_sesion character(32) NOT NULL,
    formulario character(100) NOT NULL,
    campo character(100) NOT NULL,
    valor text NOT NULL,
    fecha character(50) NOT NULL
);
 (   DROP TABLE public.polux_tempformulario;
       public         postgres    false    5            �            1259    17151    polux_usuario    TABLE     �  CREATE TABLE polux_usuario (
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
 !   DROP TABLE public.polux_usuario;
       public         postgres    false    5            �            1259    17149    polux_usuario_id_usuario_seq    SEQUENCE     ~   CREATE SEQUENCE polux_usuario_id_usuario_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 3   DROP SEQUENCE public.polux_usuario_id_usuario_seq;
       public       postgres    false    190    5            o           0    0    polux_usuario_id_usuario_seq    SEQUENCE OWNED BY     O   ALTER SEQUENCE polux_usuario_id_usuario_seq OWNED BY polux_usuario.id_usuario;
            public       postgres    false    189            �            1259    17169    polux_usuario_subsistema    TABLE     �   CREATE TABLE polux_usuario_subsistema (
    id_usuario integer DEFAULT 0 NOT NULL,
    id_subsistema integer DEFAULT 0 NOT NULL,
    estado integer DEFAULT 0 NOT NULL
);
 ,   DROP TABLE public.polux_usuario_subsistema;
       public         postgres    false    5            �            1259    17193    polux_valor_sesion    TABLE     �   CREATE TABLE polux_valor_sesion (
    sesionid character(32) NOT NULL,
    variable character(20) NOT NULL,
    valor character(255) NOT NULL,
    expiracion bigint DEFAULT 0 NOT NULL
);
 &   DROP TABLE public.polux_valor_sesion;
       public         postgres    false    5            �            1259    17066    GE_SFACU    SEQUENCE     ~   CREATE SEQUENCE "GE_SFACU"
    START WITH 246
    INCREMENT BY 1
    NO MINVALUE
    MAXVALUE 999999999999999999
    CACHE 1;
 *   DROP SEQUENCE trabajosdegrado."GE_SFACU";
       trabajosdegrado       postgres    false    7            �            1259    17068    ge_tfacu    TABLE     M  CREATE TABLE ge_tfacu (
    facu_facu bigint DEFAULT nextval('"GE_SFACU"'::regclass) NOT NULL,
    facu_nom character varying(4000) NOT NULL,
    facu_dir character varying(4000) NOT NULL,
    facu_tel character varying(50) NOT NULL,
    facu_mail character varying(100) NOT NULL,
    facu_descri character varying(4000) NOT NULL
);
 %   DROP TABLE trabajosdegrado.ge_tfacu;
       trabajosdegrado         postgres    false    174    7            p           0    0    TABLE ge_tfacu    COMMENT     g   COMMENT ON TABLE ge_tfacu IS 'Tabla que almacena la información de las facultades de la universidad';
            trabajosdegrado       postgres    false    175            q           0    0    COLUMN ge_tfacu.facu_facu    COMMENT     R   COMMENT ON COLUMN ge_tfacu.facu_facu IS 'Código identificador de cada facultad';
            trabajosdegrado       postgres    false    175            r           0    0    COLUMN ge_tfacu.facu_nom    COMMENT     @   COMMENT ON COLUMN ge_tfacu.facu_nom IS 'nombre de la facultad';
            trabajosdegrado       postgres    false    175            s           0    0    COLUMN ge_tfacu.facu_dir    COMMENT     T   COMMENT ON COLUMN ge_tfacu.facu_dir IS 'dirección donde se encuentra la facultad';
            trabajosdegrado       postgres    false    175            t           0    0    COLUMN ge_tfacu.facu_tel    COMMENT     M   COMMENT ON COLUMN ge_tfacu.facu_tel IS 'teléfono principal de la facultad';
            trabajosdegrado       postgres    false    175            u           0    0    COLUMN ge_tfacu.facu_mail    COMMENT     Z   COMMENT ON COLUMN ge_tfacu.facu_mail IS 'email donde se puede contactar con la facultad';
            trabajosdegrado       postgres    false    175            v           0    0    COLUMN ge_tfacu.facu_descri    COMMENT     I   COMMENT ON COLUMN ge_tfacu.facu_descri IS 'descripción de la facultad';
            trabajosdegrado       postgres    false    175            �            1259    17053    usuario    TABLE       CREATE TABLE usuario (
    id_usuario character(12) NOT NULL,
    nombre character(30) NOT NULL,
    telefono character(10) NOT NULL,
    email character(30) NOT NULL,
    genero character(10) NOT NULL,
    fecha_registro date NOT NULL,
    clave character(20)
);
 $   DROP TABLE trabajosdegrado.usuario;
       trabajosdegrado         postgres    false    7            �           2604    17082 	   id_bloque    DEFAULT     r   ALTER TABLE ONLY polux_bloque ALTER COLUMN id_bloque SET DEFAULT nextval('polux_bloque_id_bloque_seq'::regclass);
 E   ALTER TABLE public.polux_bloque ALTER COLUMN id_bloque DROP DEFAULT;
       public       postgres    false    176    177    177            �           2604    17094 
   idrelacion    DEFAULT     �   ALTER TABLE ONLY polux_bloque_pagina ALTER COLUMN idrelacion SET DEFAULT nextval('polux_bloque_pagina_idrelacion_seq'::regclass);
 M   ALTER TABLE public.polux_bloque_pagina ALTER COLUMN idrelacion DROP DEFAULT;
       public       postgres    false    178    179    179            �           2604    17105    id_parametro    DEFAULT     �   ALTER TABLE ONLY polux_configuracion ALTER COLUMN id_parametro SET DEFAULT nextval('polux_configuracion_id_parametro_seq'::regclass);
 O   ALTER TABLE public.polux_configuracion ALTER COLUMN id_parametro DROP DEFAULT;
       public       postgres    false    181    180    181            �           2604    17116 
   idconexion    DEFAULT     p   ALTER TABLE ONLY polux_dbms ALTER COLUMN idconexion SET DEFAULT nextval('polux_dbms_idconexion_seq'::regclass);
 D   ALTER TABLE public.polux_dbms ALTER COLUMN idconexion DROP DEFAULT;
       public       postgres    false    182    183    183            �           2604    17133    id    DEFAULT     d   ALTER TABLE ONLY polux_logger ALTER COLUMN id SET DEFAULT nextval('polux_logger_id_seq'::regclass);
 >   ALTER TABLE public.polux_logger ALTER COLUMN id DROP DEFAULT;
       public       postgres    false    185    186    186            �           2604    17139 	   id_pagina    DEFAULT     r   ALTER TABLE ONLY polux_pagina ALTER COLUMN id_pagina SET DEFAULT nextval('polux_pagina_id_pagina_seq'::regclass);
 E   ALTER TABLE public.polux_pagina ALTER COLUMN id_pagina DROP DEFAULT;
       public       postgres    false    188    187    188            �           2604    17180    id_subsistema    DEFAULT     �   ALTER TABLE ONLY polux_subsistema ALTER COLUMN id_subsistema SET DEFAULT nextval('polux_subsistema_id_subsistema_seq'::regclass);
 M   ALTER TABLE public.polux_subsistema ALTER COLUMN id_subsistema DROP DEFAULT;
       public       postgres    false    192    193    193            �           2604    17154 
   id_usuario    DEFAULT     v   ALTER TABLE ONLY polux_usuario ALTER COLUMN id_usuario SET DEFAULT nextval('polux_usuario_id_usuario_seq'::regclass);
 G   ALTER TABLE public.polux_usuario ALTER COLUMN id_usuario DROP DEFAULT;
       public       postgres    false    190    189    190            M          0    17079    polux_bloque 
   TABLE DATA               F   COPY polux_bloque (id_bloque, nombre, descripcion, grupo) FROM stdin;
    public       postgres    false    177   �e       w           0    0    polux_bloque_id_bloque_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('polux_bloque_id_bloque_seq', 1, false);
            public       postgres    false    176            O          0    17091    polux_bloque_pagina 
   TABLE DATA               [   COPY polux_bloque_pagina (idrelacion, id_pagina, id_bloque, seccion, posicion) FROM stdin;
    public       postgres    false    179   [i       x           0    0 "   polux_bloque_pagina_idrelacion_seq    SEQUENCE SET     J   SELECT pg_catalog.setval('polux_bloque_pagina_idrelacion_seq', 36, true);
            public       postgres    false    178            Q          0    17102    polux_configuracion 
   TABLE DATA               F   COPY polux_configuracion (id_parametro, parametro, valor) FROM stdin;
    public       postgres    false    181   �j       y           0    0 $   polux_configuracion_id_parametro_seq    SEQUENCE SET     L   SELECT pg_catalog.setval('polux_configuracion_id_parametro_seq', 20, true);
            public       postgres    false    180            S          0    17113 
   polux_dbms 
   TABLE DATA               v   COPY polux_dbms (idconexion, nombre, dbms, servidor, puerto, conexionssh, db, esquema, usuario, password) FROM stdin;
    public       postgres    false    183   �l       z           0    0    polux_dbms_idconexion_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('polux_dbms_idconexion_seq', 1, true);
            public       postgres    false    182            T          0    17122    polux_estilo 
   TABLE DATA               0   COPY polux_estilo (usuario, estilo) FROM stdin;
    public       postgres    false    184   \m       V          0    17130    polux_logger 
   TABLE DATA               2   COPY polux_logger (id, evento, fecha) FROM stdin;
    public       postgres    false    186   ym       {           0    0    polux_logger_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('polux_logger_id_seq', 1, false);
            public       postgres    false    185            X          0    17136    polux_pagina 
   TABLE DATA               Y   COPY polux_pagina (id_pagina, nombre, descripcion, modulo, nivel, parametro) FROM stdin;
    public       postgres    false    188   �m       |           0    0    polux_pagina_id_pagina_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('polux_pagina_id_pagina_seq', 1, false);
            public       postgres    false    187            ]          0    17177    polux_subsistema 
   TABLE DATA               \   COPY polux_subsistema (id_subsistema, nombre, etiqueta, id_pagina, observacion) FROM stdin;
    public       postgres    false    193   [p       }           0    0 "   polux_subsistema_id_subsistema_seq    SEQUENCE SET     J   SELECT pg_catalog.setval('polux_subsistema_id_subsistema_seq', 1, false);
            public       postgres    false    192            ^          0    17187    polux_tempformulario 
   TABLE DATA               S   COPY polux_tempformulario (id_sesion, formulario, campo, valor, fecha) FROM stdin;
    public       postgres    false    194   xp       Z          0    17151    polux_usuario 
   TABLE DATA               }   COPY polux_usuario (id_usuario, nombre, apellido, correo, telefono, imagen, clave, tipo, estilo, idioma, estado) FROM stdin;
    public       postgres    false    190   �p       ~           0    0    polux_usuario_id_usuario_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('polux_usuario_id_usuario_seq', 1, false);
            public       postgres    false    189            [          0    17169    polux_usuario_subsistema 
   TABLE DATA               N   COPY polux_usuario_subsistema (id_usuario, id_subsistema, estado) FROM stdin;
    public       postgres    false    191   �p       _          0    17193    polux_valor_sesion 
   TABLE DATA               L   COPY polux_valor_sesion (sesionid, variable, valor, expiracion) FROM stdin;
    public       postgres    false    195   �p                  0    0    GE_SFACU    SEQUENCE SET     4   SELECT pg_catalog.setval('"GE_SFACU"', 246, false);
            trabajosdegrado       postgres    false    174            K          0    17068    ge_tfacu 
   TABLE DATA               \   COPY ge_tfacu (facu_facu, facu_nom, facu_dir, facu_tel, facu_mail, facu_descri) FROM stdin;
    trabajosdegrado       postgres    false    175   �p       I          0    17053    usuario 
   TABLE DATA               ^   COPY usuario (id_usuario, nombre, telefono, email, genero, fecha_registro, clave) FROM stdin;
    trabajosdegrado       postgres    false    173   	q       �           2606    17099    polux_bloque_pagina_pkey 
   CONSTRAINT     k   ALTER TABLE ONLY polux_bloque_pagina
    ADD CONSTRAINT polux_bloque_pagina_pkey PRIMARY KEY (idrelacion);
 V   ALTER TABLE ONLY public.polux_bloque_pagina DROP CONSTRAINT polux_bloque_pagina_pkey;
       public         postgres    false    179    179            �           2606    17088    polux_bloque_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY polux_bloque
    ADD CONSTRAINT polux_bloque_pkey PRIMARY KEY (id_bloque);
 H   ALTER TABLE ONLY public.polux_bloque DROP CONSTRAINT polux_bloque_pkey;
       public         postgres    false    177    177            �           2606    17110    polux_configuracion_pkey 
   CONSTRAINT     m   ALTER TABLE ONLY polux_configuracion
    ADD CONSTRAINT polux_configuracion_pkey PRIMARY KEY (id_parametro);
 V   ALTER TABLE ONLY public.polux_configuracion DROP CONSTRAINT polux_configuracion_pkey;
       public         postgres    false    181    181            �           2606    17121    polux_dbms_pkey 
   CONSTRAINT     Y   ALTER TABLE ONLY polux_dbms
    ADD CONSTRAINT polux_dbms_pkey PRIMARY KEY (idconexion);
 D   ALTER TABLE ONLY public.polux_dbms DROP CONSTRAINT polux_dbms_pkey;
       public         postgres    false    183    183            �           2606    17127    polux_estilo_pkey 
   CONSTRAINT     b   ALTER TABLE ONLY polux_estilo
    ADD CONSTRAINT polux_estilo_pkey PRIMARY KEY (usuario, estilo);
 H   ALTER TABLE ONLY public.polux_estilo DROP CONSTRAINT polux_estilo_pkey;
       public         postgres    false    184    184    184            �           2606    17148    polux_pagina_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY polux_pagina
    ADD CONSTRAINT polux_pagina_pkey PRIMARY KEY (id_pagina);
 H   ALTER TABLE ONLY public.polux_pagina DROP CONSTRAINT polux_pagina_pkey;
       public         postgres    false    188    188            �           2606    17186    polux_subsistema_pkey 
   CONSTRAINT     h   ALTER TABLE ONLY polux_subsistema
    ADD CONSTRAINT polux_subsistema_pkey PRIMARY KEY (id_subsistema);
 P   ALTER TABLE ONLY public.polux_subsistema DROP CONSTRAINT polux_subsistema_pkey;
       public         postgres    false    193    193            �           2606    17168    polux_usuario_pkey 
   CONSTRAINT     _   ALTER TABLE ONLY polux_usuario
    ADD CONSTRAINT polux_usuario_pkey PRIMARY KEY (id_usuario);
 J   ALTER TABLE ONLY public.polux_usuario DROP CONSTRAINT polux_usuario_pkey;
       public         postgres    false    190    190            �           2606    17198    polux_valor_sesion_pkey 
   CONSTRAINT     q   ALTER TABLE ONLY polux_valor_sesion
    ADD CONSTRAINT polux_valor_sesion_pkey PRIMARY KEY (sesionid, variable);
 T   ALTER TABLE ONLY public.polux_valor_sesion DROP CONSTRAINT polux_valor_sesion_pkey;
       public         postgres    false    195    195    195            �           2606    17076    pk_ge_tfacu 
   CONSTRAINT     R   ALTER TABLE ONLY ge_tfacu
    ADD CONSTRAINT pk_ge_tfacu PRIMARY KEY (facu_facu);
 G   ALTER TABLE ONLY trabajosdegrado.ge_tfacu DROP CONSTRAINT pk_ge_tfacu;
       trabajosdegrado         postgres    false    175    175            �           2606    17057    usuario_pkey 
   CONSTRAINT     S   ALTER TABLE ONLY usuario
    ADD CONSTRAINT usuario_pkey PRIMARY KEY (id_usuario);
 G   ALTER TABLE ONLY trabajosdegrado.usuario DROP CONSTRAINT usuario_pkey;
       trabajosdegrado         postgres    false    173    173            M   c  x���N1���S�����HH Q(�^�=	�{k{��8}��[�y���zR5Ȇ�IGHD�o��y���Έ��TW<��Hvf��Q4_<�J�B�x���s�3��'ж��.|�{yWvƬT��b7�f]���3e�:����7\��������}&\%3�_G�%w������ޟ�� !�Z<�EzX w�|P�g�@�����C�`�|p6]�^��@<��.U+r�� �J��� ��ů�J�er�q� FI;��$�l�I��@��D�6		�?A�RM��� ���,�5���.+u�{8G�n >�c@��<�CC���U=E��0bX���u�	�si�́S�Pi�-���ӡ��	I.�1�A��������i��A�cV��)�}�J��;`��:@Q'j���N<�'[�m(4�~X>�+w�1L��@� �7]6;��W�+ٵ�h��~7��8.��(�W���2�Z�����:F�6��ߋK���.��_�/�x3nOС��r�J-���>��R:�Xsp��ҁ�$����o�`����A��aK�4��&�`}�o��4uC�k:�Z�7����I�����h3�2�)DJ����-�O>TRqR�~�����sС���s����΁]��~�9�I0!O_���n���UsY�]�H�e��m�t���364_�	��__���	!��x��{���/sr�9��cܫ�Yu���(_u~�A�~��� ����W�����s��~�d�Mſ���B����rw���t�����6����!�Gq-g
�S��f���O���x���2R�:���: ��      O   }  x�=�Ar!E��]fJE�I*����1����Ň~oP���$���<y�_�y�/ϊ|ڏ� ����!'���&y�(R�<��ZPd�\����P��(n:v9��"��Ql8C"���t�DAGQX:+R9h�c(��zJ7�Giv�2�Ji��Ҝq��pђ
J;���5�?<8ؽ'\���c��s���ܾ� r��?/zy&��M�<�>�4��oSҫG;�%�s�+�^����#?���C����>�X7~�݇��Ҍ��Ν������c:�홸E&~|d��s�֣�_�I��'o�'lKr�e�����sR�!$�mA�ċU�s�f�c�Q}U�����e�v+b3�����$�D�q�"�{'�	��ȷ��~�����      Q   �  x��Mn�0F�3��E���U�AM`4E�E��"i��aHJu}��6��7���<R�R5�������H$��;ͭ�� &�r?�ۄ����8�@}��U��*n�X��m�6���ސz���?.���c��bH�j�$E�Q.��@WJ��*OZy�s���]�����E�x��0�.��%n���ԑ�s�^�rp϶���>\}z����O��z���m��s��&\7󏏋ۆ����)%Kb# +��
���J��;*�r�XS�m�:`}6x��`Tz���dO76����HZK(}�X�aM���W1s۰ ��`�@�Zݩ���=�-��HnT�-����&�����m�,�x��\�E����J��C�������##t`�|:�X_�i������:~��g'�W���̓`�J��>b]���yZ&kl��wAVY S+\�Vԥ�K��1"�-~~�      S   p   x�3�L-.)*M.)-J�,H/.����ON���/.�4516��,��)��,(M��Lr�KҋR�9SM�|�}t�+��s�B�ʂrR�
*����rL�L�="L�L�b���� ��#      T      x������ � �      V      x������ � �      X   �  x��ˊ�0���Sh՝gƙ����t�@Ӥ�u��'Fő�#+t�6}��GȋU�g� �Ԯ>������(&)� W�d�� �2��l����\��CsD���ıF_�\g��7���D��ב{oW<)/����_t�H�&�"oA�T�V5�&�Oӡ+V4�F���i�9OܗF��^�Y���_5�2htA���H6��2i"x��6�̖ ɇ�\��]�L��{���5�X�̄U����9h˂g^���v3i�1I��ͦB������S�g�����tI�qf�`�Y-��;�Bd��Z�`�4�!�#�S�� p��F�7'��l�6˒:<d�j�f��T��8�?�sK���m��S�mfַ��4&bs�������	)���j�$�P��x��d#�Q��.�je � A2�9�&*�Bn���͙m'+�@�Ȑ�]�=&H���%{@�!_�A����=�3�M�%.�K��zYK�F�&\�.�{F2��1A2�U-�G�[C��{�	�>ړ��ʦF�7�R���<���L�pnC$���h�zI��zC����2�ОdM|��M��z[w�9ا���,ٮ��.5zJ����a8�v����eC5.X��c�j2�c���!)��x����{L����r�.�5�������~,�~>����"rS      ]      x������ � �      ^      x������ � �      Z      x������ � �      [      x������ � �      _      x������ � �      K      x������ � �      I   ]   x�3444T�΂��ԤD�������I�Cznbf�^r~.�J����Ҝ̼|N#CS]C#]Cs�L�D�Ҩd����
s/�=... YA      