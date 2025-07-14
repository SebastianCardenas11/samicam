-- Script para verificar la estructura y datos de la tabla tbl_funcionarios_planta

-- Mostrar la estructura de la tabla
DESCRIBE tbl_funcionarios_planta;

-- Mostrar algunos registros de ejemplo
SELECT 
    idefuncionario,
    nombre_completo,
    nm_identificacion,
    correo_elc,
    celular,
    direccion,
    lugar_de_residencia,
    fecha_ingreso,
    hijos,
    nombres_de_hijos,
    sexo,
    edad,
    estado_civil,
    religion,
    formacion_academica,
    nombre_formacion,
    lugar_expedicion,
    libreta_militar,
    tipo_nombramiento,
    nivel,
    salario_basico,
    acto_administrativo,
    fecha_acto_nombramiento,
    no_acta_posesion,
    fecha_acta_posesion,
    tiempo_laborado,
    codigo,
    grado,
    fecha_nacimiento,
    lugar_nacimiento,
    rh,
    titulo,
    tarjeta_profesional,
    otros_estudios,
    cuenta_no,
    banco,
    eps,
    afp,
    afc,
    arl,
    sindicalizado,
    madre_cabeza_hogar,
    prepensionado,
    status
FROM tbl_funcionarios_planta 
LIMIT 3; 