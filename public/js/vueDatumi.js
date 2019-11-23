let vueDate=new Vue(
    {
        el:".vueSelector",
        data:
        {
            dateStartNew:'',
            dateEndNew:'',
            showSD: true,
            showED: true,
            dateStartModel:null,
            dateEndModel:null,
        },
        methods:
        {
            inputStartDate()
            {
                this.dateStartNew=pf.dateToSerbianFormat(this.dateStartModel);
                this.showSD=false;
            },

            inputEndDate()
            {
                this.dateEndNew=pf.dateToSerbianFormat(this.dateEndModel);
                this.showED=false;
            },

            outputStartDate()
            {
                this.dateStartModel="";
                this.showSD=true;
            },

            outputEndDate()
            {
                this.dateEndModel="";
                this.showED=true;
            },
        },
    }
);