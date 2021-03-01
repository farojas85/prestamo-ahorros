import moment from 'moment-timezone/builds/moment-timezone-with-data'

Vue.filter('miFecha', function(created){
    return moment(created).tz('America/Lima').format('DD/MM/YYYY');
});

Vue.filter('diferenciaDias',function(fechaInicio){
    var fecha1 = moment(fechaInicio).tz('America/Lima');
    var fecha2 = moment(new Date()).tz('America/Lima');

    if(fechaInicio == null || fechaInicio =='')
    {
        return null;
    }
    return fecha2.diff(fecha1,'days');
})
