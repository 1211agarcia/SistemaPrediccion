#Regresion lineal


#se cargan los datos colocando como parametros que los decimales seran separados por un ","
data <- read.table("nuevos_datos.txt",header=TRUE,dec=",")
data
#Nombre de columnas a ignorar para este experimento, calclulo de ignora pues es la salida deseada
drops <- c("cant_mats","segunda_opc","Gestion_Plantel","Tipo_Plantel","Nivel_Socioeconomico","Estudio_Padres","primera_opc","opsu")
#se descarta Cant_cats por tener correlacion poco significativa
data <- data[ , !(names(data) %in% drops)]
data
y <- data[,7]
y
x <- data[,1:5]
x
fit <- lm(y ~ x[,1] + x[,2] + x[,3] + x[,4] + x[,5])

summary(fit)

# Other useful functions 
coefficients(fit) # model coefficients
confint(fit, level=0.95) # CIs for model parameters 
fitted(fit) # predicted values
residuals(fit) # residuals
anova(fit) # anova table 
vcov(fit) # covariance matrix for model parameters 
influence(fit) # regression diagnostics

# diagnostic plots 
layout(matrix(c(1,2,3,4),2,2)) # optional 4 graphs/page 
plot(fit)

ECM <- mean(residuals(fit)^2)
ECM