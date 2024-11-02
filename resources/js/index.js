import AirDatepicker from 'air-datepicker'

export default function filamentAirDatepicker({
    state,
    minDate,
    maxDate,
    format,
    hasTime,
    onlyTime,
    hoursStep,
    minutesStep,
    startHour,
    minHours,
    maxHours,
    minMinutes,
    maxMinutes,
    classes,
    defaultState
}) {
    return {
        state,
        minDate,
        maxDate,
        format,
        hasTime,
        onlyTime,
        hoursStep,
        minutesStep,
        startHour,
        minHours,
        maxHours,
        minMinutes,
        maxMinutes,
        classes,
        defaultState,

        datepicker: null,

        init() {
            let today = new Date()

            if (this.startHour) {
                const time = this.startHour.split(':')
                const hours = Number.isNaN(parseInt(time[0])) ? today.getHours() : parseInt(time[0])
                const minutes = Number.isNaN(parseInt(time[1])) ? today.getMinutes() : parseInt(time[1])

                today.setHours(hours)
                today.setMinutes(minutes)
            }

            today.setSeconds(0)

            let options = {
                inline: true,
                autoClose: false,
                toggleSelected: false,
                locale: window.filamentData.locale.datepicker,
                selectedDates: [new Date()],
                startDate: today,
                dateFormat: this.format || 'yyyy-MM-dd',
                timepicker: this.hasTime || this.onlyTime,
                timeFormat: 'HH:mm',
                hoursStep: this.hoursStep || 1,
                minutesStep: this.minutesStep || 15,
                minHours: this.minHours || 0,
                maxHours: this.maxHours || 23,
                minMinutes: this.minMinutes || 0,
                maxMinutes: this.maxMinutes || 59,
                onlyTimepicker: this.onlyTime,
                classes: this.classes,
                onSelect: ({date, formattedDate, datepicker}) => {
                    this.setState(formattedDate)
                }
            }

            if (this.minDate) {
                options.minDate = this.minDate
            }

            if (this.maxDate) {
                options.maxDate = this.maxDate
            }

            if (this.datepicker === undefined || this.datepicker === null) {
                this.datepicker = new AirDatepicker( this.$refs.datepicker, options)
            }

            this.datepicker.selectDate(today, { updateTime: true })
        },

        setState(state) {
            this.state = state
        }
    }
}
