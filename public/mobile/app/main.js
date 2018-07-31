import  React from "react";
import {render} from  "react-dom";
import App from "./App.js"
// import mdui from "mdui"
// import "../node_modules/mdui/dist/js/mdui.min"
require(`../node_modules/mdui/dist/css/mdui.css`);
require(`../node_modules/mdui/dist/js/mdui.min.js`);
let $$ = mdui.JQ;
render(
    <div>
        <div className="mdui-tab mdui-tab-full-width" mdui-tab>
            <a href="#example4-tab1" className="mdui-ripple">web</a>
            <a href="#example4-tab2" className="mdui-ripple">shopping</a>
            <a href="#example4-tab3" className="mdui-ripple">videos</a>
        </div>
        <div className="mdui-tab-indicator"></div>
        <App/>
    </div>
    ,
    document.getElementById("app-container")
);