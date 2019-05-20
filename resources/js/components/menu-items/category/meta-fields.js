export const metaFields = {
  category_slug: null
}

export const setMetaFields = (object, subject) => {
  if(typeof subject.meta_data != "object") {
    console.log("meta_data - не объект")
  } else {
    if(!("category_slug" in subject.meta_data)) {
      console.log("В meta_data - нету поля 'category_slug'")
      object.category_slug = null
    } else {
      object.category_slug = subject.meta_data.category_slug
    }
  }
}