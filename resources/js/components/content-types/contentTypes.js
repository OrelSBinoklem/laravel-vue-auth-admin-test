export const contentTypes = {
	get() {
		return {
      contentTypes: [
        {
          name: 'JS плагин',
          slug: 'js-plugin',
          component: 'js-plugin',
          hashGroups: {
            static_properties: {title: 'Статические свойства'},
            properties: {title: 'Свойства'},
            methods: {title: 'Методы'}
          }
        }
      ]
		}
	}
}