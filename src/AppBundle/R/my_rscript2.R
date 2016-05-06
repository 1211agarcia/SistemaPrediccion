#		cat("TITLE extra line", "2 3 5 7", "11 13 17", file = "data.txt", sep = "\n")
scan("data.txt")
pp <- scan("data.txt", skip = 1, quiet = TRUE)
scan("data.txt", skip = 1)
scan("data.txt", skip = 1, nlines = 1) # only 1 line after the skipped one
scan("data.txt", what = list("","","")) # flush is F -> read "7"
scan("data.txt", what = list("","",""), flush = TRUE)
unlink("data.txt") # tidy up

## "inline" usage
scan(text = "1 2 3")