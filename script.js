fetch('/api/redis/', {
	method: 'get'
}).then((response) => {
	return response.json();
}).then((data) => {
	console.log(data);
	if (data.status === false && data.code === 500) {
		alert(data.data.message);
	} else {
		for (const [key, value] of Object.entries(data.data)) {
			const list = document.getElementById('list')
			const newListItem = document.createElement('li');
			const keyValueTextNode = document.createTextNode(key + ': ' + value);
			const removeLink = document.createElement('a');

			newListItem.setAttribute('data-key', key)

			removeLink.classList.add('cursor-pointer', 'ms-2', 'link-danger');
			removeLink.setAttribute('href', '#');
			removeLink.text = 'delete';

			removeLink.addEventListener('click', function (event) {
				event.preventDefault();

				const listItem = this.parentElement;
				const deletingKey = listItem.getAttribute('data-key');

				this.classList.add('text-secondary');
				this.style.pointerEvents = 'none';
				listItem.classList.add('text-secondary');

				fetch('/api/redis/' + deletingKey, {
					method: 'delete'
				}).then((response) => {
					return response.json();
				}).then((data) => {
					if (data.status === false && data.code === 500) {
						alert(data.data.message);
					} else {
						listItem.remove();
					}
				});
			});

			newListItem.append(keyValueTextNode, removeLink);
			list.appendChild(newListItem);
		}
	}
});