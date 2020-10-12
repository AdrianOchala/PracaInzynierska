<template>
    <gmaps-map :options="mapOptions" style="height: 50vh" class="mt-4">
        <gmaps-marker :options="optionsA" />
    </gmaps-map>
</template>
<script>
import { gmapsMap, gmapsMarker,gmapsPopup } from 'x5-gmaps';
export default {
    name:'SingleCompanyLocation',
    props:['center','name'],
    components: { gmapsMap, gmapsMarker,gmapsPopup },
    data(){
        return{
            optionsA: {
                position: this.center,
                title: 'Twój znacznik',
                clickable: true,
                label:this.name ,
            },
            mapOptions: {
                center: this.center,
                zoom: 12,
            },
        }
    }
}
</script>
