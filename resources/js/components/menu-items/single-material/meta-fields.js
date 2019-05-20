export const metaFields = {
  content_type: null,
  material_slug: null
}

export const setMetaFields = (object, subject) => {
  if(typeof subject.meta_data != "object") {
    console.log("meta_data - не объект")
  } else {
    if(!("content_type" in subject.meta_data)) {
      console.log("В meta_data - нету поля 'content_type'")
      object.content_type = null
    } else {
      object.content_type = subject.meta_data.content_type
    }
    if(!("material_slug" in subject.meta_data)) {
      console.log("В meta_data - нету поля 'material_slug'")
      object.material_slug = null
    } else {
      object.material_slug = subject.meta_data.material_slug
    }
  }
}