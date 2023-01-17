import {trans} from "../translator/translator";
import screenfull from "screenfull";
import "leaflet";
import "leaflet.locatecontrol";
import "leaflet.markercluster";
import "leaflet.fullscreen";
import "leaflet.gridlayer.googlemutant";
import 'leaflet.markercluster.freezable';

window.screenfull = screenfull;

const PUBLIC_URL = `${window.location.protocol}//${window.location.hostname}/wp-content/themes/payeye2.0/public/`;
const ICON_URL = PUBLIC_URL + 'icon/';

export class GoogleMap {
    constructor(listPartners) {
        let zoom = 10;
        let lat = 51.1267432;
        let lon = 17.0116858;
        this.isMobile = window.innerWidth < 678;

        let dragging;

        if (listPartners) {
            dragging = true;
        } else {
            dragging = !L.Browser.mobile;
        }

        this.map = L.map('map', {
            tap: false,
            scrollWheelZoom: false,
            dragging: dragging,
        }).setView([lat, lon], zoom);

        L.control.locate({
            strings: {
                title: trans.myLocation,
            }
        }).addTo(this.map);

        if (screenfull.isEnabled) {
            this.map.addControl(new L.Control.FullScreen());
        }

        L.gridLayer
            .googleMutant({
                minZoom: 7,
                maxZoom: 18,
                styles: this.styles().style,
            })
            .addTo(this.map);

        this.markersClusterGroup = L.markerClusterGroup({
            showCoverageOnHover: !this.isMobile,
            spiderLegPolylineOptions: {
                color: '#00AD93',
                opacity: 0
            },
            polygonOptions: {
                color: '#00AD93',
                weight: 2,
            },
        });
    }

    selectPoint(id, markers) {
        markers.forEach(marker => {
            const markerId = marker.options.id;

            if (markerId === id) {
                this.markersClusterGroup.disableClustering();
                this.centerMarker(marker.getLatLng());
                marker.openPopup();
            }

        })
    }

    setActiveMarker(id, markers) {
        markers.forEach(marker => {
            const markerId = marker.options.title;
            marker._icon.src = this.styles().icon.standard;

            marker._icon.classList.remove('leaflet-marker-icon--active');
            if (markerId === id) {
                marker._icon.src = this.styles().icon.promo;
            }

        })
    }

    centerMarker(location) {
        let marker = L.marker([location.lat - 0.0004, location.lng - 0.0005]);

        if (this.isMobile) {
            marker = L.marker([location.lat - 0.0005, location.lng]);
        }


        let group = new L.featureGroup([marker]);
        this.map.fitBounds(group.getBounds());
    }

    styles() {
        return {
            icon: {
                standard: ICON_URL + 'map/partner/standard.svg',
                promo: ICON_URL + 'map/partner/promo.svg',
            },
            style: [
                {
                    elementType: "geometry",
                    stylers: [
                        {
                            color: "#f5f5f5",
                        },
                    ],
                },
                {
                    elementType: "labels.icon",
                    stylers: [
                        {
                            visibility: "off",
                        },
                    ],
                },
                {
                    elementType: "labels.text.fill",
                    stylers: [
                        {
                            color: "#616161",
                        },
                    ],
                },
                {
                    elementType: "labels.text.stroke",
                    stylers: [
                        {
                            color: "#f5f5f5",
                        },
                    ],
                },
                {
                    featureType: "administrative.land_parcel",
                    elementType: "labels.text.fill",
                    stylers: [
                        {
                            color: "#bdbdbd",
                        },
                    ],
                },
                {
                    featureType: "poi",
                    elementType: "geometry",
                    stylers: [
                        {
                            color: "#eeeeee",
                        },
                    ],
                },
                {
                    featureType: "poi",
                    elementType: "labels.text.fill",
                    stylers: [
                        {
                            color: "#757575",
                        },
                    ],
                },
                {
                    featureType: "poi.park",
                    elementType: "geometry",
                    stylers: [
                        {
                            color: "#e5e5e5",
                        },
                    ],
                },
                {
                    featureType: "poi.park",
                    elementType: "labels.text.fill",
                    stylers: [
                        {
                            color: "#9e9e9e",
                        },
                    ],
                },
                {
                    featureType: "road",
                    elementType: "geometry",
                    stylers: [
                        {
                            color: "#ffffff",
                        },
                    ],
                },
                {
                    featureType: "road.arterial",
                    elementType: "labels.text.fill",
                    stylers: [
                        {
                            color: "#757575",
                        },
                    ],
                },
                {
                    featureType: "road.highway",
                    elementType: "geometry",
                    stylers: [
                        {
                            color: "#dadada",
                        },
                    ],
                },
                {
                    featureType: "road.highway",
                    elementType: "labels.text.fill",
                    stylers: [
                        {
                            color: "#616161",
                        },
                    ],
                },
                {
                    featureType: "road.local",
                    elementType: "labels.text.fill",
                    stylers: [
                        {
                            color: "#9e9e9e",
                        },
                    ],
                },
                {
                    featureType: "transit.line",
                    elementType: "geometry",
                    stylers: [
                        {
                            color: "#e5e5e5",
                        },
                    ],
                },
                {
                    featureType: "transit.station",
                    elementType: "geometry",
                    stylers: [
                        {
                            color: "#eeeeee",
                        },
                    ],
                },
                {
                    featureType: "water",
                    elementType: "geometry",
                    stylers: [
                        {
                            color: "#c9c9c9",
                        },
                    ],
                },
                {
                    featureType: "water",
                    elementType: "labels.text.fill",
                    stylers: [
                        {
                            color: "#9e9e9e",
                        },
                    ],
                },
            ],
        }
    }
}
