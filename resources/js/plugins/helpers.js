import moment from 'moment';

export default {
    formatDate(date) {
        return moment(date).format('MMMM Do YYYY')
    },

    formatTime(date) {
        return moment(date).format('h:mm a')
    },
}
