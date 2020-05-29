// import UnderlineTool from "@editorjs/underline";
import ChecklistTool from "@editorjs/checklist";
import CodeTool from "@editorjs/code";
import DelimiterTool from "@editorjs/delimiter";
import EditorJS from "@editorjs/editorjs";
import EmbedTool from "@editorjs/embed";
import HeaderTool from "@editorjs/header";
import ImageTool from "@editorjs/image";
import InlineCodeTool from "@editorjs/inline-code";
import LinkTool from "@editorjs/link";
import ListTool from "@editorjs/list";
import MarkerTool from "@editorjs/marker";
import ParagraphTool from "@editorjs/paragraph";
import QuoteTool from "@editorjs/quote";
import RawTool from "@editorjs/raw";
import TableTool from "@editorjs/table";
import WarningTool from "@editorjs/warning";

export default class extends window.Controller {
  tools = {
    HeaderTool: HeaderTool,
    ImageTool: ImageTool,
    TableTool: TableTool,
    ParagraphTool: ParagraphTool,
    LinkTool: LinkTool,
    EmbedTool: EmbedTool,
    ListTool: ListTool,
    CodeTool: CodeTool,
    ChecklistTool: ChecklistTool,
    MarkerTool: MarkerTool,
    WarningTool: WarningTool,
    RawTool: RawTool,
    QuoteTool: QuoteTool,
    InlineCodeTool: InlineCodeTool,
    DelimiterTool: DelimiterTool
  };

  getClass(name) {
    return this.tools[name];
  }

  getTools() {
    let json = JSON.parse(this.data.get("tools"));
    for (let [key, value] of Object.entries(json)) {
      if (typeof value === "string") {
        json[key] = this.getClass(value);
      } else {
        json[key].class = this.getClass(json[key].class);
      }
    }
    return json;
  }

  connect() {
    const input = this.element.querySelector("input");

    let data = undefined;

    try {
      data = JSON.parse(input.value);
    } catch (error) {
      data = undefined;
    }

    this.editor = new EditorJS({
      holder: this.element.querySelector(".editorjs"),
      tools: this.getTools(),
      data: data,
      onChange: function(api) {
        api.saver.save().then(savedData => {
          input.value = JSON.stringify(savedData);
        });
      }
    });
  }
}
