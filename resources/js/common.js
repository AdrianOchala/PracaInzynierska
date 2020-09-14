export default {
    data(){
        return{

        }
    },
    methods:{
        async callApi(method, url, dataObject){
            try{
                return await axios({
                    method:method,
                    url:url,
                    data:dataObject
                });
            }catch(e){
                return e.response
            }
        }
    }
}
