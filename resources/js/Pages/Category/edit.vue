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
	category: {
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
const form = useForm({...usePage().props.category});
console.log(form);
</script>

<template>
	<Head :title="category.id > 0 ? 'Редактирование '+category.name : 'Добавление категории'" />

	<AuthenticatedLayout>
		<template #header>
			<h1 class="text-xl font-semibold leading-tight text-gray-800">{{ category.id > 0 ? 'Редактирование: ' + category.name : 'Добавление категории'}}</h1>
		</template>

		<div class="py-12">
			<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 ">

				<Breadcrumbs class="mb-3" :breadcrumbs="breadcrumbs"/>

				<form
					@submit.prevent="category.id > 0 ? form.patch(route('category.update', [category.id])) : form.post(route('category.create'))"
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
								placeholder="Название категории"
								required
								autocomplete="name"
							/>

							<InputError class="mt-2" :message="form.errors.name" />
						</div>

						<div class="mb-3">
							<InputLabel for="tech" value="Технологии" />

							<autocomplete v-model:tags="form.tags" url="/api/tags"></autocomplete>
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
