import {mapGetters} from "vuex";

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
        },
        checkUserPermission(key){
            if(!this.userPermission) return true;
            let isPermitted = false;
            for (let i of this.userPermission) {
                if(this.$route.name===i.name){
                    if(i[key]){
                        isPermitted = true;
                        break;
                    }else{
                        break;
                    }
                }

            }
            return isPermitted;
        },
    },
    computed:{
        ...mapGetters({'userPermission' : 'getUserPermission'}),
        isRead(){
            return this.checkUserPermission('read')
        },
        isWrite(){
            return this.checkUserPermission('write')
        },
        isUpdate(){
            return this.checkUserPermission('update')
        },
        isDelete(){
            return this.checkUserPermission('delete')
        },
    },
}
