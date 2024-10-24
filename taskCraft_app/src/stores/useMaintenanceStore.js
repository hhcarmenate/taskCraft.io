import { defineStore } from 'pinia'

export const useMaintenanceStore = defineStore('maintenance', {
  state: () => ({
    inMaintenance: false,
    maintenanceReason: 'Routine Maintenance'
  }),
  persist: false,
  actions: {
    toogleMaintenance() {
      this.inMaintenance = !this.inMaintenance
    },
    turnOnMaintenance() {
      this.inMaintenance = true
    },
    turnOffMaintenance() {
      this.inMaintenance = false
    },
    setMaintenanceReason(reason) {
      this.maintenanceReason = reason
    }
  }
})
