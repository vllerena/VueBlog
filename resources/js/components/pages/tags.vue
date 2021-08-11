<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Tags <Button><Icon type="md-add" /> Add Tag</Button></p>
                    <div class="_overflow _table_div">
                        <table class="_table">
                            <tr>
                                <th>Date</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                            <tr>
                                <td>25-05-19</td>
                                <td class="_table_name">Manhattan's art center "Shed" opening ceremony</td>
                                <td>Economy</td>
                                <td>
                                    <Button type="info" size="small">Edit</Button>
                                    <Button type="error" size="small">Error</Button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "tags",
    async created(){
        const res = await this.callApi('post', 'api/app/create_tag', {tagName: 'TestTag'});
        console.log(res)
        if (res.status === 200){
            console.log(res)
        } else {
            console.log('running')
        }
    }
}
</script>

<style scoped>

</style>
