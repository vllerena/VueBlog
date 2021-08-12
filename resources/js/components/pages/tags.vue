<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Tags <Button @click="addModal=true"><Icon type="md-add" /> Add Tag</Button></p>
                    <div class="_overflow _table_div">
                        <table class="_table">
                            <tr>
                                <th>ID</th>
                                <th>Tag name</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                            <tr v-for="(tag, i) in tags" :key="i" v-if="tags.length">
                                <td>{{tag.id}}</td>
                                <td class="_table_name">{{tag.tagName}}</td>
                                <td>{{tag.created_at}}</td>
                                <td>
                                    <Button type="info" size="small" @click="showEditModal(tag, i)">Edit</Button>
                                    <Button type="error" size="small" @click="deleteModal=true" :loading="tag.isDeleting">Delete</Button>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <Modal
                        v-model="addModal"
                        title="Add Tag"
                        :mask-closable="false"
                        :closable="false">
                        <Input v-model="data.tagName" placeholder="Add tag name" />
                        <div slot="footer">
                            <Button type="default" @click="addModal=false">Close</Button>
                            <Button type="primary" @click="addTag" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding..' : 'Add Tag'}}</Button>
                        </div>
                    </Modal>
                    <Modal
                        v-model="editModal"
                        title="Edit Tag"
                        :mask-closable="false"
                        :closable="false">
                        <Input v-model="editData.tagName" placeholder="Add tag name" />
                        <div slot="footer">
                            <Button type="default" @click="editModal=false">Close</Button>
                            <Button type="primary" @click="editTag" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing..' : 'Edit Tag'}}</Button>
                        </div>
                    </Modal>
                    <Modal v-model="deleteModal" width="360">
                        <p slot="header" style="color:#f60;text-align:center">
                            <Icon type="ios-information-circle"></Icon>
                            <span>Delete confirmation</span>
                        </p>
                        <div style="text-align:center">
                            <p>Are u sure u want to delete this tag?</p>
                        </div>
                        <div slot="footer">
                            <Button type="error" size="large" long :loading="deleteModal" :disabled="deleteModal" @click="deleteTag">Delete</Button>
                        </div>
                    </Modal>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "tags",
    data(){
      return{
          data : {
            tagName: ''
          },
          editData: {
              tagName: ''
          },
          addModal: false,
          editModal: false,
          deleteModal: false,
          isAdding: false,
          tags: [],
          index: -1,
      }
    },
    methods: {
        async addTag(){
            const res = await this.callApi('post', 'api/app/create_tag', this.data);
            if (res.status === 201){
                this.tags.unshift(res.data)
                this.success('Tag has been added successfully!')
                this.addModal = false
                this.data.tagName = ''
            } else {
                if (res.status === 422){
                    if(res.data.errors.tagName){
                        this.info(res.data.errors.tagName[0])
                    }
                } else {
                    this.swr()
                }
            }
        },
        async editTag(){
            const res = await this.callApi('post', 'api/app/edit_tag', this.editData);
            if (res.status === 200){
                this.tags[this.index].tagName = this.editData.tagName
                this.success('Tag has been edited successfully!')
                this.editModal = false
            } else {
                if (res.status === 422){
                    if(res.data.errors.tagName){
                        this.info(res.data.errors.tagName[0])
                    }
                } else {
                    this.swr()
                }
            }
        },
        showEditModal(tag, index){
            let obj = {
                id: tag.id,
                tagName: tag.tagName
            }
            this.editData = obj
            this.editModal = true
            this.index = index
        },
        async deleteTag(tag, i){
            if (!confirm('Are u sure u want to delete this tag')) return
            this.$set(tag, 'isDeleting', true)
            const res = await this.callApi('post', 'api/app/delete_tag', tag);
            console.log(res)
            if(res.status === 200){
                this.tags.splice(i, 1)
                this.success('Tag has been deleted successfully!')
            } else {
                this.swr()
            }
        }
    },
    async created(){
        const res = await this.callApi('get', 'api/app/get_tag')
        if (res.status === 200){
            this.tags = res.data
            console.log(this.tags)
        } else {
            this.swr()
        }
    }
}
</script>

<style scoped>

</style>
