import moment from 'moment-timezone/builds/moment-timezone-with-data'

Vue.filter('miFecha', function(created){
    return moment(created).tz('America/Lima').format('DD/MM/YYYY');
});
