import DOM from './core/dom.js';
import Camera from './camera/camera.js';
import Capture from './camera/capture.js';
import Export from './export/export.js';
import Modify from './stickers/modify.js';
import Stickers from './stickers/stickers.js';
import States from './core/states.js';
import Events from './core/events.js';

Camera.init();
Capture.init();
Export.init();
Modify.init();
Stickers.init();
States.init();
Events.prepare();