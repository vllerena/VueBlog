<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Admin User <Button @click="addModal=true"><Icon type="md-add" /> Add Admin</Button></p>
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
                                    <Button type="error" size="small" @click="showDeleteModal(tag, i)" :loading="tag.isDeleting">Delete</Button>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <Modal
                        v-model="addModal"
                        title="Add Admin"
                        :mask-closable="false"
                        :closable="false">
                        <Input type="text" class="mb-3" v-model="data.tagName" placeholder="Full name" />
                        <Input type="email" class="mb-3" v-model="data.tagName" placeholder="Email" />
                        <Input type="password" class="mb-3" v-model="data.tagName" placeholder="Password" />
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
                            <Button type="primary" @click="editTag" :disabled="isEditing" :loading="isEditing">{{isEditing ? 'Editing..' : 'Edit Tag'}}</Button>
                        </div>
                    </Modal>
                    <deleteModal></deleteModal>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import deleteModal from '../deleteModal'
import { mapGetters } from 'vuex'
export default {
    name: "adminusers",
    components: {deleteModal},
    data(){
        return{
            data : {
                tagName: '',

            },
            editData: {
                tagName: ''
            },
            addModal: false,
            editModal: false,
            deleteModal: false,
            isAdding: false,
            isEditing: false,
            isDeleting: false,
            tags: [],
            index: -1,
            deleteItem: {},
            deletingIndex: -1,
        }
    },
    methods: {
        async addTag(){
            this.isAdding = true
            const res = await this.callApi('post', 'api/app/create_tag', this.data);
            if (res.status === 201){
                this.tags.unshift(res.data)
                this.success('Tag has been added successfully!')
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
            this.isAdding = false
            this.addModal = false
        },
        async editTag(){
            this.isEditing = true
            const res = await this.callApi('post', 'api/app/edit_tag', this.editData);
            if (res.status === 200){
                this.tags[this.index].tagName = this.editData.tagName
                this.success('Tag has been edited successfully!')
            } else {
                if (res.status === 422){
                    if(res.data.errors.tagName){
                        this.info(res.data.errors.tagName[0])
                    }
                } else {
                    this.swr()
                }
            }
            this.isEditing = false
            this.editModal = false
        },
        async deleteTag(){
            this.isDeleting = true
            const res = await this.callApi('post', 'api/app/delete_tag', this.deleteItem);
            if(res.status === 200){
                this.tags.splice(this.deletingIndex, 1)
                this.success('Tag has been deleted successfully!')
            } else {
                this.swr()
            }
            this.isDeleting = false
            this.deleteModal = false
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
        showDeleteModal(tag, index){
            const deleteModalObj = {
                showDeleteModal: true,
                deleteUrl: 'api/app/delete_tag',
                data: tag,
                deletingIndex: index,
                isDeleting: false,
                successMsg: "Tag eliminado",
                msg: "¿Deseas eliminar el tag?, esta acción no puede revertirse"
            }
            this.$store.commit('setDeletingModalObj', deleteModalObj)
        },
    },
    async created(){
        const res = await this.callApi('get', 'api/app/get_tag')
        if (res.status === 200){
            this.tags = res.data
            console.log(this.tags)
        } else {
            this.swr()
        }
    },
    computed : {
        ...mapGetters(['getDeleteModalObj'])
    },
    watch : {
        getDeleteModalObj(obj){
            if(obj.isDeleted){
                this.tags.splice(obj.deletingIndex,1)
            }
        }
    }
}
</script>

<style scoped>

</style>
