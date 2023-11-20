<template>
    <div>
        <input type="text" placeholder="Escribe riesgo" v-model="query" v-on:keyup="autoComplete" class="form-control">
        <div class="panel-footer" v-if="results.length">
            <ul class="list-group">
                <li class="list-group-item" v-for="result in results" v-on:click="query=result.des_riesgo">
                    {{ result.des_riesgo }}
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
    export default{

    }
</script>