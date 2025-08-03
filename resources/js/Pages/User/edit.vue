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
	user: {
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
const form = useForm({...usePage().props.user});
console.log(form);
</script>

<template>
	<Head :title="user.id > 0 ? 'Редактирование '+user.name : 'Добавление пользователя'" />

	<AuthenticatedLayout>
		<template #header>
			<h1 class="text-xl font-semibold leading-tight text-gray-800">{{ user.id > 0 ? 'Редактирование: ' + user.name : 'Добавление пользователя'}}</h1>
		</template>

		<div class="py-12">
			<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 ">

				<Breadcrumbs class="mb-3" :breadcrumbs="breadcrumbs"/>

				<form
					@submit.prevent="user.id > 0 ? form.patch(route('users.update', [user.id])) : form.post(route('users.create'))"
					class="space-y-6"
				>
					<div class="bg-white person-card">

						<div class="mb-3 lg:flex-1">
							<InputLabel for="name" value="Имя" />

							<TextInput
								id="name"
								type="text"
								class="mt-1 block w-full"
								v-model="form.name"
								required
								autocomplete="name"
							/>

							<InputError class="mt-2" :message="form.errors.name" />
						</div>

						<div class="mb-3 lg:flex-1">
							<InputLabel for="email" value="Email" />

							<TextInput
								id="email"
								type="email"
								class="mt-1 block w-full"
								v-model="form.email"
								required
								autocomplete="email"
							/>

							<InputError class="mt-2" :message="form.errors.email" />
						</div>

						<div class="mb-3 lg:flex-1">
							<InputLabel for="password" value="Пароль" />

							<TextInput
								id="password"
								type="password"
								class="mt-1 block w-full"
								v-model="form.password"
								autocomplete="off"
								required
							/>

							<InputError class="mt-2" :message="form.errors.password" />
						</div>

						<div class="mb-3 lg:flex-1">
							<InputLabel for="password_confirmation" value="Повтор пароля" />

							<TextInput
								id="password_confirmation"
								type="password"
								class="mt-1 block w-full"
								autocomplete="off"
								v-model="form.password_confirmation"
								required
							/>

							<InputError class="mt-2" :message="form.errors.password_confirmation" />
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
