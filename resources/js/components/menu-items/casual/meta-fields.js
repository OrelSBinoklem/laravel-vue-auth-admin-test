export const metaFields = {
  is_router: false
}

export const setMetaFields = (object, subject) => {
  if(typeof subject.meta_data != "object") {
    console.log("meta_data - не объект")
  } else {
    if(!("is_router" in subject.meta_data)) {
      console.log("В meta_data - нету поля 'is_router'")
      object.is_router = false
    } else {
      object.is_router = !!subject.meta_data.is_router
    }
  }
}