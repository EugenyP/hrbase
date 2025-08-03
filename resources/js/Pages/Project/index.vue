<script setup>
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import NavLink from '@/components/NavLink.vue';
import { Head } from '@inertiajs/vue3';
import Icon from "@/components/Icon.vue";
import PrimaryButton from "@/components/PrimaryButton.vue";
import PersonList from "@/components/PersonList.vue";
import Breadcrumbs from "@/components/Breadcrumbs.vue";

defineProps({
	person: {
		type: Object
	},
	projects: {
		type: Array
	},
	paginate: {
		type: String
	},
	breadcrumbs: {
		type: Array,
		required: false,
		default: []
	},
});
</script>

<template>
	<Head title="Список" />

	<AuthenticatedLayout>
		<template #header>
			<div class="flex justify-between">
				<h1
					class="text-xl font-semibold leading-tight text-gray-800"
				>{{person.firstname}} {{person.lastname}}: Проекты</h1>


				<a title="" class="inline-flex gap-1 place-items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" :href="route('persons.edit.projects.new', person.id)">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="block"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
					Добавить проект
				</a>
			</div>
		</template>

		<div class="py-12">
			<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
				<Breadcrumbs class="mb-3" :breadcrumbs="breadcrumbs"/>
				<div class="text-gray-900 bg-slate-50">
					<table v-if="projects.length" class="border-collapse table-auto w-full text-sm">
						<thead>
						<tr>
							<th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pb-3 text-slate-400 dark:text-slate-200 text-left">ID</th>
							<th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pb-3 text-slate-400 dark:text-slate-200 text-left">Название</th>
							<th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pb-3 text-slate-400 dark:text-slate-200 text-left">Позиция</th>
							<th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pb-3 text-slate-400 dark:text-slate-200 text-left">Дата проекта</th>
							<th class="border-b dark:border-slate-600 font-medium p-4 pl-8 pb-3 text-slate-400 dark:text-slate-200 text-left"></th>
						</tr>
						</thead>
						<tbody class="bg-white">
						<tr v-for="project in projects">
							<td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{ project.id }}</td>
							<td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400"><NavLink :href="route('person.show', person.id)">{{ project.name }}</NavLink></td>
							<td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{ project.position }}</td>
							<td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">{{ project.startdate }} - {{ project.enddate }}</td>
							<td class="border-b border-slate-100 dark:border-slate-700 p-4 pl-8 w-10">
								<a class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" :href="route('persons.edit.projects.edit', [person.id, project.id])">
									<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
										<path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/>
										<path d="m15 5 4 4"/>
									</svg>
								</a>
							</td>
						</tr>
						</tbody>
					</table>
					<div v-else class="border-b border-slate-100 text-center dark:border-slate-700 p-4 pl-8 text-slate-500 dark:text-slate-400">
						<p>Проектов нет</p>
						<br/>
						<p><NavLink :href="route('persons.edit.projects.new', person.id)">Создать?</NavLink></p>
					</div>
				</div>
				<div v-if="paginate" class="mt-8" v-html="paginate"></div>
			</div>
		</div>

	</AuthenticatedLayout>
</template>
