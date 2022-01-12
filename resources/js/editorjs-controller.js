import EditorJS from "@editorjs/editorjs"
// tools
import ParagraphTool from "@editorjs/paragraph"
import HeaderTool from "@editorjs/header"
import LinkTool from "@editorjs/link"
import ImageTool from "@editorjs/image"
import EmbedTool from "@editorjs/embed"
import ListTool from "@editorjs/list"
import QuoteTool from "@editorjs/quote"

export default class extends window.Controller {
  static targets = [
    'input',
    'holder',
  ]

  static defaultTools = {
    ParagraphTool,
    HeaderTool,
    LinkTool,
    ImageTool,
    EmbedTool,
    ListTool,
    QuoteTool,
  }

  tunes = []

  initialize() {
    window.editorJSTools = window.editorJSTools || []
  }

  async connect() {
    const tools = this.getTools()

    const config = {
      holder: this.holderTarget,

      tools: tools,
      tunes: this.tunes,

      data: this.value,

      placeholder: this.placeholder,
      minHeight: this.minHeight,
      readonly: this.readonly,
    }

    dispatchEvent(new CustomEvent('orchid:editorjs:config', {
      detail: {
        inputName: this.inputName,
        config,
        inputTarget: this.inputTarget,
      }
    }))

    this.editor = new EditorJS({
      ...config,
      onChange: async (api) => {
        try {
          this.value = await api.saver.save()
        } catch (error) {
          console.error(error)
        }
      }
    })

    try {
      await this.editor.isReady

      dispatchEvent(new CustomEvent('orchid:editorjs:ready', {
        detail: {
          inputName: this.inputName,
          editor: this.editor,
          inputTarget: this.inputTarget,
        }
      }))
    } catch (reason) {
      console.error(`Editor.js initialization failed because of ${reason}`)
    }
  }

  getClass(toolName) {
    return window?.editorJSTools?.[toolName] ?? this.constructor.defaultTools[toolName] ?? toolName
  }

  getTools() {
    let json = JSON.parse(this.data.get("tools"))

    for (let [key, value] of Object.entries(json)) {
      if (typeof value === "string") {
        json[key] = {
          class: this.getClass(value)
        }
      } else {
        json[key].class = this.getClass(json[key].class)
      }

      if (json[key]?.isGlobalTune) {
        this.tunes.push(key)
      }

      const detail = {
        inputName: this.inputName,
        toolName: key,
        toolConfig: json[key],
      }

      dispatchEvent(new CustomEvent('orchid:editorjs:tool', { detail }))
      dispatchEvent(new CustomEvent(`orchid:editorjs:tool:${key}`, { detail }))

      if (typeof json[key]?.class === "string" || typeof json[key]?.class === "undefined") {
        delete json[key]

        console.warn(`Ignore [${key}] tool`);

        continue
      }
    }

    return json
  }

  disconnect() {
    this.editor?.destroy()
  }

  get placeholder() {
    return this.data.get('placeholder')
  }

  get readonly() {
    return this.data.get('readonly') === 'true'
  }

  get minHeight() {
    return this.data.get('minHeight')
  }

  get inputName() {
    return this.inputTarget.name
  }

  get value() {
    try {
      return JSON.parse(this.inputTarget.value)
    } catch (error) {
      return undefined
    }
  }

  set value(data) {
    try {
      this.inputTarget.value = JSON.stringify(data)
    } catch (error) {
      this.inputTarget.value = '{}'
    } finally {
      this.inputTarget.dispatchEvent(new Event('change'))
    }
  }
}
