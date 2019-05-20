export const metaFields = {
  is_router: false,
  path: ''
}

export const setMetaFields = (object, subject) => {
  if(typeof subject.meta_data != "object") {
    console.log("meta_data - не объект")
  } else {

    //is_router
    if(!("is_router" in subject.meta_data)) {
      console.log("В meta_data - нету поля 'is_router'")
      object.is_router = false
    } else {
      object.is_router = !!subject.meta_data.is_router
    }

    //path
    if(!("path" in subject.meta_data)) {
      console.log(subject.meta_data)
      console.log("В meta_data - нету поля 'path'")
      object.path = ''
    } else {
      object.path = subject.meta_data.path
    }
  }
}