import _ from 'lodash'

export const mContentHashes = {
  methods: {
    parseHashes(positions) {
      let result = []

      recursion(positions)

      function recursion(positions) {
        _.valuesIn(positions).forEach((position) => {
          if('widgets' in position) {

            position.widgets.forEach((widget) => {

              if(_.get(widget, 'props.navHash.title'))
                result.push(widget.props.navHash)

              if('positions' in widget)
                recursion(widget.positions)

            })

          }
        })
      }

      return result
    }
  }
}