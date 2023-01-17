export class BusinessZoneVideo {
    constructor(node) {
        this.node = node;
        node.querySelector('video').currentTime = 3;
    }
}
