<script setup>
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import NavLink from '@/components/NavLink.vue';
import { Head } from '@inertiajs/vue3';
import Breadcrumbs from "@/components/Breadcrumbs.vue";

defineProps({
	person: {
		type: Object,
	},
	breadcrumbs: {
		type: Array,
		required: false,
		default: []
	},
});
</script>

<template>
	<Head :title="person.fio" />

	<AuthenticatedLayout>
		<template #header>
			<div class="flex justify-between">
				<h1 class="text-xl font-semibold leading-tight text-gray-800">
					{{ person.fio }} - {{ person.position }}
				</h1>
				<a class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" :href="route('person.edit', person.id)">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/>
						<path d="m15 5 4 4"/>
					</svg>
				</a>
			</div>
		</template>

		<div class="py-12">
			<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 ">
				<Breadcrumbs class="mb-3" :breadcrumbs="breadcrumbs"/>
				<div class="bg-white person-card mb-10">
					<div><b>Ф.И.О:</b> {{ person.fio }}</div>
					<div><b>Опыт:</b> {{ person.position }}</div>
					<div><b>Дата рождения:</b> {{ person.birthday}}</div>
					<div><b>Город:</b> {{ person.city }}</div>
				</div>

				<div class="bg-white person-card">
					<h2 class="text-l font-semibold text-gray-800">Технологии</h2>

					<div>
						<div v-for="tag in person.tags">
							{{ tag.name.ru }} - {{ person.exp[tag.id] }} мес
						</div>
					</div>
				</div>

			</div>
		</div>

	</AuthenticatedLayout>
</template>
<style scoped>
.person-card {
	padding: 10px;
}
</style>
