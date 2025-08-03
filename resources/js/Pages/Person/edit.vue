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
defineProps({
	person: {
		type: Object,
	},
	categories: {
		type: Array,
		required: false,
		default: []
	},
	breadcrumbs: {
		type: Array,
		required: false,
		default: []
	},
});
const form = useForm({...usePage().props.person});

</script>

<template>
	<Head :title="person.id > 0 ? 'Редактирование '+person.fio : 'Добавление кандидита'" />

	<AuthenticatedLayout :breadcrumbs="breadcrumbs">
		<template #header>
			<h1 class="text-xl font-semibold leading-tight text-gray-800">{{ person.id > 0 ? 'Редактирование: ' + person.fio + ' - ' + person.position : 'Добавление кандидата'}}</h1>
		</template>

		<div class="py-12">
			<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 ">
				<Breadcrumbs class="mb-3" :breadcrumbs="breadcrumbs"/>
				<form
					@submit.prevent="person.id > 0 ? form.patch(route('person.update', person.id)) : form.post(route('person.create'))"
					class="space-y-6"
				>
					<div class="bg-white person-card">
						<div class="flex gap-5 flex-wrap ">
							<div class="mb-3 lg:flex-1">
								<InputLabel for="fio" value="Ф.И.О" />

								<TextInput
									id="fio"
									type="text"
									class="mt-1 block w-full"
									v-model="form.fio"
									required
									autocomplete="fio"
								/>

								<InputError class="mt-2" :message="form.errors.fio" />
							</div>
						</div>

						<div class="mb-3 w-40">
							<select class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 mt-1 block w-full" v-model="form.category_id">
								<option value="0" :selected="form.category_id == 0">Без категории</option>
								<option v-for="category in categories" :selected="category.id == form.category_id" :value="category.id">{{category.name}}</option>
							</select>
						</div>
						<div class="flex gap-5 flex-wrap ">
							<div class="mb-3 w-40">
								<InputLabel for="position" value="Опыт" />

								<TextInput
									id="position"
									type="text"
									class="mt-1 block w-full"
									v-model="form.position"
									required
									autocomplete="position"
								/>

								<InputError class="mt-2" :message="form.errors.position" />
							</div>
						</div>
						<div class="flex gap-5 flex-wrap ">
							<div class="mb-3 w-40">
								<InputLabel for="birthday" value="Дата рождения" />

								<TextInput
									id="birthday"
									type="date"
									class="mt-1 block w-full"
									v-model="form.birthday"
									required
									autocomplete="birthday"
								/>

								<InputError class="mt-2" :message="form.errors.birthday" />
							</div>
						</div>
						<div class="flex gap-5 flex-wrap ">
							<div class="mb-3 w-40">
								<InputLabel for="city" value="Город" />

								<TextInput
									id="city"
									type="text"
									class="mt-1 block w-full"
									v-model="form.city"
									required
									autocomplete="city"
								/>

								<InputError class="mt-2" :message="form.errors.city" />
							</div>
							<div class="mb-3 w-40">
								<InputLabel for="address" value="Адрес" />

								<TextInput
									id="address"
									type="text"
									class="mt-1 block w-full"
									v-model="form.address"
									autocomplete="address"
								/>

								<InputError class="mt-2" :message="form.errors.address" />
							</div>
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

				<NavLink v-if="person.id > 0" :href="route('persons.edit.projects', person.id)">Проекты</NavLink>
			</div>
		</div>

	</AuthenticatedLayout>
</template>
<style scoped>
.person-card {
	padding: 15px;
}
</style>
