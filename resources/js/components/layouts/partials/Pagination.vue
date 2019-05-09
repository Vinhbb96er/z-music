<template>
    <ul class="pagination" v-if="pageData && pageData.last_page != 1">
        <li v-if="pageData.current_page != 1" class="prev">
            <a href="#" @click.prevent="loadPageFunc(pageData.current_page - 1)">
                <span aria-hidden="true"><i class="fa fa-angle-double-left"></i></span>
            </a>
        </li>
        <template v-for="page in pageData.last_page">
            <li v-if="page == pageData.current_page" class="active">
                <a href="#" @click.prevent>{{ page }}</a>
            </li>
            <li v-else-if="checkPage(page)" :class="{active: page == pageData.current_page}">
                <a href="#" @click.prevent="loadPageFunc(page)">{{ page }}</a>
            </li>
            <li v-else-if="page == pageData.last_page - 1 || page == 2">
                <a href="#" @click.prevent>...</a>
            </li>
        </template>
        <li v-if="pageData.current_page != pageData.last_page" class="next">
            <a href="#" @click.prevent="loadPageFunc(pageData.current_page + 1)">
                <span aria-hidden="true"><i class="fa fa-angle-double-right"></i></span>
            </a>
        </li>
    </ul>
</template>
<script>
    export default {
        props: {
            pageData: {
                required: true,
                type: Object
            },
            loadPageFunc: {
                required: true,
                type: Function
            }
        },
        methods: {
            checkPage(page) {
                return page == this.pageData.current_page + 1
                    || page == this.pageData.current_page - 1
                    || page == this.pageData.last_page
                    || page == 1;
            }
        }
    }
</script>
<style>

</style>
