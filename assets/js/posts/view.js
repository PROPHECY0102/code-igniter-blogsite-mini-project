console.log("posts/view.js loaded in " + window.location.href);

const baseurl = document
	.querySelector(".metadata")
	.getAttribute("data-base-url");
const btnDeletePost = document.querySelector(".btn-delete-post");

async function deletePost(id) {
	return await fetch(`${baseurl}posts/delete/${id}`, {
		method: "POST",
		headers: {
			"Content-Type": "application/json",
		},
		body: JSON.stringify({
			data: "data",
		}),
	});
}

btnDeletePost.addEventListener("click", async () => {
	const postID = btnDeletePost.getAttribute("data-post-id");
	try {
		const res = await deletePost(postID);
		if (!res.ok) {
			throw new Error(`Error! Status: ${response.status}`);
		}
		const queryResult = await res.json();
		console.log(queryResult.result);
		window.location.href = queryResult.redirect;
	} catch (error) {
		console.error(error);
	}
});
