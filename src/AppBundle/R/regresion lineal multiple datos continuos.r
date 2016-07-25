#Regresion lineal


#se cargan los datos colocando como parametros que los decimales seran separados por un ","
data <- read.table("muestra_real.txt",header=TRUE)
data
#Nombre de columnas a ignorar para este experimento, calculo de ignora pues es la salida deseada
drops <- c("cant_mat","opsu","gestion_plantel","tipo_plantel","nivel_socioeco","nivel_estudios_padres","genero","escuela")
#se descarta Cant_cats por tener correlacion poco significativa
data <- data[ , !(names(data) %in% drops)]
data
pairs(data)

cor(data)

matematica_1 <- data[,1]
matematica_2 <- data[,2]
matematica_3 <- data[,3]
matematica_4 <- data[,4]
promedio <- data[,5]
calculo_1 <- data[,6]
x11()
par(mfrow=c(1,2))
plot(calculo_1,matematica_1)
plot(calculo_1,matematica_2)
x11()
par(mfrow=c(1,2))
plot(calculo_1,matematica_3)
plot(calculo_1,matematica_4)
x11()
par(mfrow=c(1,1))
plot(calculo_1,promedio)

mod1 <- lm(calculo_1 ~ x[,1] + x[,2] + x[,3] + x[,4] + x[,5])

summary(mod1)

# Other useful functions 
coefficients(mod1) # model coefficients
confint(mod1, level=0.95) # CIs for model parameters 
fitted(mod1) # predicted values
residuals(mod1) # residuals
anova(mod1) # anova table 
vcov(mod1) # covariance matrix for model parameters 
influence(mod1) # regression diagnostics

# diagnostic plots 
layout(matrix(c(1,2,3,4),2,2)) # optional 4 graphs/page 
plot(mod1)

ECM <- mean(residuals(mod1)^2)
ECM