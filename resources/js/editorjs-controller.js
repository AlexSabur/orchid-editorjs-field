import EditorJS from "@editorjs/editorjs"

export default class extends window.Controller {
  static targets = [
    'input',
    'holder',
  ]

  static defaultTools = {

  }

  initialize() {
    window.editorJSTools = window.editorJSTools || [];
  }

  getClass(toolName) {
    return window?.editorJSTools?.[toolName] ?? this.constructor.defaultTools[toolName];
  }

  getTools() {
    let json = JSON.parse(this.data.get("tools"))

    for (let [key, value] of Object.entries(json)) {
      if (typeof value === "string") {
        json[key] = this.getClass(value)
      } else {
        json[key].class = this.getClass(json[key].class)
      }

      if (typeof (json[key].class || json[key]) === "undefined") {
        delete json[key]
      }
    }

    return json
  }

  connect() {
    const tools = this.getTools();

    this.editor = new EditorJS({
      holder: this.holderTarget,
      tools: tools,
      data: this.value,
      onChange: async (api) => {
        try {
          this.value = await api.saver.save()
        } catch (error) {
          console.error(error)
        }
      }
    })

    try {
      await editor.isReady

      dispatchEvent(new CustomEvent('orchid:editorjs:ready', {
        detail: {
          editor: this.editor,
        }
      }))

      console.log('Editor.js is ready to work!')
      /** Do anything you need after editor initialization */
    } catch (reason) {
      console.log(`Editor.js initialization failed because of ${reason}`)
    }
  }

  disconnect() {
    this.editor.destroy()
  }

  get value() {
    try {
      return JSON.parse(this.valueTarget.value)
    } catch (error) {
      return undefined
    }
  }

  set value(data) {
    try {
      this.valueTarget.value = JSON.stringify(data)
    } catch (error) {
      this.valueTarget.value = '{}'
    } finally {
      this.valueTarget.dispatchEvent(new Event('change'));
    }
  }
}
