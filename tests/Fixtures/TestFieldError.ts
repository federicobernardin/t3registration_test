plugin.tx_t3registration_pi1{
    fieldConfiguration{
        first_name{
            config.eval = int
            singleErrorEvaluate = 1
        }
        last_name{
            config.eval = regexp
            regexp = ^[Surname]
        }

    }
    _LOCAL_LANG.default{
        last_nameRegexpError = Regexp Error
        first_nameIntError = First should be a number
        tx_t3registrationtest_dateError = Date is not correct
    }

    lib{
        regexp {
            config.eval = regexp
            regexp = ^[PPPPP]
        }
        alpha{
            config.eval = alpha
        }
        string < .alpha
        int{
            config.eval = int
        }
        password{
            config.eval = password
            config.maxchars = 12
            confi.minchars = 6
        }
        unique{
            config.eval = unique
        }
        uniqueInPid{
            config.eval = uniqueInPid
        }
        required{
            config.eval = required
        }
        date{
            config.date.strftime = d.m.Y
        }
        dateWithMax < .date
        dateWithMax{
            config.date.maxDate = 1.1.2013
        }
        dateWithMin < .date
        dateWithMin{
            config.date.minDate = 1.1.2009
        }
        dateBetween < .date
        dateBetween{
            config.date.maxDate = 1.1.2013
            config.date.minDate = 1.1.2009
        }
        dateInFuture < .date
        dateInFuture{
            config.date.dateHasToBeIn = future
        }
        dateInPast < .date
        dateInPast{
            config.date.dateHasToBeIn = past
        }
    }
}
