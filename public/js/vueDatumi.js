let vueDate=new Vue(
    {
        el:"#vueSelector",
        data:
        {
            dateStartNew:null,
            dateEndNew:null,
            dateStartModel:null,
            dateEndModel:null,
        },
        methods:
        {
            inputStartDate()
            {
                this.dateStartNew=pf.dateToSerbianFormat(this.dateStartModel);
            },

            inputEndDate()
            {
                this.dateEndNew=pf.dateToSerbianFormat(this.dateEndModel);
            },

            outputStartDate()
            {
                this.dateStartModel=null;
            },

            outputEndDate()
            {
                this.dateEndModel=null;
            },
        },
    }
);