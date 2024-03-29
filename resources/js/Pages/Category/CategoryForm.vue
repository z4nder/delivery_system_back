<template>
    <form-layout @submitted="createCategory">
        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <p class="text-sm">{{ $page.flash.message }}</p>
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Nome" />
                <jet-input
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    autofocus
                />
                <jet-input-error :message="$page.errors.name" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <input type="file" class="hidden"
                            ref="photo"
                            @change="updatePhotoPreview">

                <jet-label for="photo" value="Photo" />

                <!-- New Profile Photo Preview -->
                <div class="mt-2" v-show="photoPreview">
                    <div v-if="isEdit && !editPhotoPreview">
                        <img id="old_image" :src="form.photo" class="block rounded-full w-40 h-40" :alt="form.name" />
                    </div>
                    <div v-else>
                        <span class="block rounded-full w-40 h-40"
                          :style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                        </span>
                    </div>
                </div>

                <jet-secondary-button class="mt-2 mr-2" type="button" @click.native.prevent="selectNewPhoto">
                    Escolha uma Foto
                </jet-secondary-button>

                <jet-secondary-button type="button" class="mt-2" @click.native.prevent="deletePhoto" v-if="form.photo">
                    Remover Foto
                </jet-secondary-button>

                <jet-input-error :message="$page.errors.photo" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="priority" value="Prioridade" />
                <jet-input
                    id="priority"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.priority"
                />
                <jet-input-error :message="$page.errors.priority" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Habilitado" />
                <label class="inline-flex items-center mt-3">
                    <input v-model="form.enable" type="checkbox" class="form-checkbox h-5 w-5 text-gray-600" checked><span class="ml-2 text-gray-700">Sim</span>
                 </label>
                <jet-input-error :message="$page.errors.enable" class="mt-2" />
            </div>

        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Salvo.
            </jet-action-message>

            <jet-button
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Salvar
            </jet-button>
        </template>
    </form-layout>
</template>

<script>
import JetActionMessage from "@/Jetstream/ActionMessage";
import JetButton from "@/Jetstream/Button";
import JetFormSection from "@/Jetstream/FormSection";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetLabel from "@/Jetstream/Label";
import FormLayout from "@/Layouts/FormLayout";
import JetSecondaryButton from '@/Jetstream/SecondaryButton'

export default {
    components: {
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
        FormLayout,
        JetSecondaryButton
    },
    props: ['errors', 'isEdit', 'editData'],
    data() {
        return {
            form: {
                name: "",
                photo: "",
                priority: "",
                enable: true
            },
            editPhotoPreview: false,
            photoPreview: null
        };
    },
    mounted() {
        if(this.isEdit){
            this.form = this.editData.data
        }
    },
    methods: {
        async createCategory() {
            if(this.isEdit){
                return await this.updateCategory()
            }
            if (this.$refs.photo) {
                    this.form.photo = this.$refs.photo.files[0]
            }
            var data = new FormData()
            data.append('name', this.form.name || '')
            data.append('photo', this.form.photo || '')
            data.append('priority', this.form.priority || '')
            data.append('enable', this.form.enable)

            await this.$inertia.post(route("storeCategory"), data, {
                onFinish: () => {
                  if(this.$page.errorBags.length <= 0)  this.$inertia.replace(route("indexCategory"));
                }
            })
        },
        async updateCategory() {
            let updateImage = true
            if (this.$refs.photo && this.editPhotoPreview) {
               this.form.photo = this.$refs.photo.files[0]
            }else{
               updateImage = false
            }

            var data = new FormData()
            data.append('name', this.form.name)
            data.append('photo', this.form.photo)
            data.append('priority', this.form.priority)
            data.append('enable', this.form.enable)
            data.append('updateImage', updateImage)

            await this.$inertia.post(route("updateCategory", this.form.id), data)
        },
        updatePhotoPreview() {
                const reader = new FileReader();

                reader.onload = (e) => {
                    this.photoPreview = e.target.result;
                };
                if(this.isEdit) this.editPhotoPreview = true
                reader.readAsDataURL(this.$refs.photo.files[0]);
        },
        selectNewPhoto() {
            this.$refs.photo.click();
        },
    }
};
</script>
