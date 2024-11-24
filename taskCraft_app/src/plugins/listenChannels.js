import { useWorkspaceStore } from '@/stores/useWorkspaceStore.js'

export default function listenChannels() {

  const listenPublicChannels = () => {
    window.Echo.channel('test-channel')
      .listen('TestBroadcast', (e) => {
        message.value = e.message
        console.log('Event received: ', e)
      })
  }

  const listenCurrentWorkspace = (workspaceId) => {
    const workspace = useWorkspaceStore()

    window.Echo.private(`workspace.${workspaceId}`)
      .listen('WorkspaceUpdated', (event) => {
        workspace.updateWorkspaceFromBroadcast(event)
      })
  }

  return { listenPublicChannels, listenCurrentWorkspace }
}
