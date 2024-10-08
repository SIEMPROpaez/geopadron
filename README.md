# Geopadron

Es un desarollo que trae datos básicos de geolocalización de direcciones de CABA.

## Glosario de las APIs

Si fuese necesario agregarle info a las consultas...

### API Normalizar Direcciones
https://ws.usig.buenosaires.gob.ar/rest/normalizar_direcciones?calle=julio%20roca&altura=782&desambiguar=1
    
    {
    "TipoResultado":"DireccionNormalizada",
    "DireccionesCalleAltura":{
      "direcciones":[{
                      "CodigoCalle":"19058",
                      "Calle":"ROCA, JULIO A., PRESIDENTE DIAGONAL SUR AV.",
                      "Altura":"782"
                      }]
    }


### API Datos Útiles
https://ws.usig.buenosaires.gob.ar/datos_utiles?calle=peru&altura=782

    {
    "comuna":"Comuna 1",
    "barrio":"San Telmo",
    "comisaria":"2",
    "area_hospitalaria":"HTAL. DR. C. ARGERICH",
    "region_sanitaria":"I (Este)",
    "distrito_escolar":"Distrito Escolar IV",
    "comisaria_vecinal":"1F",
    "seccion_catastral":"02",
    "distrito_economico":"",
    "codigo_de_planeamiento_urbano":"",
    "partido_amba":"",
    "localidad_amba":"",
    "codigo_postal":"1068",
    "codigo_postal_argentino":"C1068AAF"
    }

### API Datos de Catastro
https://datosabiertos-catastro-apis.buenosaires.gob.ar/catastro/parcela/?codigo_calle=17071&altura=782

    {
    "direccion":"PERU 782",
    "smp":"002-028-018",
    "seccion":"002",
    "manzana":"028",
    "parcela":"018",
    "centroide":[-58.37409739622178,-34.61697760699699],
    "srid":4326,
    "smp_anterior":"002-028-017",
    "smp_siguiente":"002-028-019B",
    "pdamatriz":"215639",
    "superficie_total":"812.00",
    "superficie_cubierta":"1451.00",
    "frente":"14.50",
    "fondo":"56.00",
    "propiedad_horizontal":"No",
    "pisos_bajo_rasante":"0",
    "pisos_sobre_rasante":"1",
    "unidades_funcionales":"0",
    "locales":"0",
    "vuc":"0.00",
    "fuente":"AGIP (2008)",
    "cantidad_puertas":1,
    "puertas":[{
                "calle":"PERU",
                "altura":782,
                "codigo_calle":17071,
                "puerta_principal":true,
                "puerta_oficial":true,
                "fuente":"DGROC Junio 2019",
                "fecha_actualizacion":"27/11/2019"
                }]
      }

### API Traer Coordenadas GKBA
https://ws.usig.buenosaires.gob.ar/geocoder/2.2/geocoding?cod_calle=17071&altura=782&metodo=puertas

    (
    {"x":"108150.992445",
    "y":"101357.282955"}
    )
