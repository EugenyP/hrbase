<script setup>
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import NavLink from '@/components/NavLink.vue';
import { Link, Head, useForm, usePage } from '@inertiajs/vue3';
import TextInput from "@/components/TextInput.vue";
import InputLabel from "@/components/InputLabel.vue";
import InputError from "@/components/InputError.vue";
import PrimaryButton from "@/components/PrimaryButton.vue";
import Breadcrumbs from "@/components/Breadcrumbs.vue";

//console.log(usePage().props);
const props = defineProps({
	person: {
		type: Object,
	},
	project: {
		type: Object
	},
	breadcrumbs: {
		type: Array,
		required: false,
		default: []
	},
});
const form = useForm({...usePage().props.project});

</script>

<template>
	<Head :title="project.id > 0 ? 'Редактирование '+project.name : 'Добавление проекта'" />

	<AuthenticatedLayout>
		<template #header>
			<h1 class="text-xl font-semibold leading-tight text-gray-800">{{ project.id > 0 ? 'Редактирование: ' + person.firstname + ' ' + person.lastname + ' - ' + person.position : 'Добавление проекта'}}</h1>
		</template>

		<div class="py-12">
			<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 ">

				<Breadcrumbs class="mb-3" :breadcrumbs="breadcrumbs"/>

				<form
					@submit.prevent="project.id > 0 ? form.patch(route('persons.edit.projects.update', [person.id, project.id])) : form.post(route('persons.edit.projects.new', person.id))"
					class="space-y-6"
				>
					<div class="bg-white person-card">

						<div class="mb-3 lg:flex-1">
							<InputLabel for="name" value="Название" />

							<TextInput
								id="name"
								type="text"
								class="mt-1 block w-full"
								v-model="form.name"
								placeholder="Название проекта"
								required
								autocomplete="name"
							/>

							<InputError class="mt-2" :message="form.errors.name" />
						</div>

						<div class="flex gap-5 flex-wrap ">
							<div class="mb-3 flex-1">
								<InputLabel for="position" value="Позиция" />

								<TextInput
									id="position"
									type="text"
									class="mt-1 block w-full"
									v-model="form.position"
									placeholder="Позиция кандидата на проекте"
									required
									autocomplete="position"
								/>

								<InputError class="mt-2" :message="form.errors.position" />
							</div>
						</div>
						<div class="flex gap-5 flex-wrap ">
							<div class="mb-3 w-40">
								<InputLabel for="startdate" value="Начало проекта" />

								<TextInput
									id="startdate"
									type="date"
									class="mt-1 block w-full"
									v-model="form.startdate"
									required
									autocomplete="startdate"
								/>

								<InputError class="mt-2" :message="form.errors.startdate" />
							</div>
							<div class="mb-3 w-40">
								<InputLabel for="enddate" value="Конец проекта" />

								<TextInput
									id="enddate"
									type="date"
									class="mt-1 block w-full"
									v-model="form.enddate"
									required
									autocomplete="enddate"
								/>

								<InputError class="mt-2" :message="form.errors.enddate" />
							</div>
						</div>
						<div class="mb-3">
							<InputLabel for="tech" value="Технологии" />

							<autocomplete v-model:tags="form.tags" url="/api/tags"></autocomplete>
						</div>

						<div class="">
							<div class="mb-3">
								<InputLabel for="description" value="Описание" />

								<TextInput
									id="description"
									type="textarea"
									class="mt-1 block w-full min-h-16"
									v-model="form.description"
									autocomplete="description"
								/>

								<InputError class="mt-2" :message="form.errors.description" />
							</div>
						</div>
						<div class="flex items-center gap-4">
							<PrimaryButton :disabled="form.processing">Сохранить</PrimaryButton>

							<Transition
								enter-active-class="transition ease-in-out"
								enter-from-class="opacity-0"
								leave-active-class="transition ease-in-out"
								leave-to-class="opacity-0"
							>
								<p
									v-if="form.recentlySuccessful"
									class="text-sm text-gray-600"
								>
									Saved.
								</p>
							</Transition>
						</div>
					</div>
				</form>

			</div>
		</div>

	</AuthenticatedLayout>
</template>
<style>
.person-card {
	padding: 15px;
}
.tags-input * + input[type="text"] {
	margin-top: 10px;
	min-width: 100%;
	width: 100%;
}
</style>
