##########################################################
# Contruir y Entrena la Red
#########################################################

source("PCAfunction.r")
graphics.off()
library(AMORE)
#########################
#se cargan los datos colocando como parametros que los decimales seran separados por un ","
data <- read.table("muestra_estudiantes.txt",header=TRUE)
#Nombre de columnas a ignorar para este experimento, calclulo de ignora pues es la salida deseada
drops <- c("cant_mat","escuela","gestion_plantel","tipo_plantel","nivel_socioeco","nivel_estudios_padres","genero","opsu")

y <- data[ , !(names(data) %in% drops)]
y
ptm <- proc.time()
trains <- validacion_cruzada(y, 10)
proc.time() - ptm
