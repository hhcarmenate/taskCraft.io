import { useWorkspaceStore } from '@/stores/useWorkspaceStore.js'

export default function listenChannels() {

  const listenPublicChannels = () => {
    window.Echo.channel('test-channel')
      .listen('TestBroadcast', (e) => {
        console.log('Event received: ', e.message)
      })
  }

  const listenCurrentWorkspace = (workspaceId) => {
    const workspace = useWorkspaceStore()

    window.Echo.private(`workspace.${workspaceId}`)
      .listen('WorkspaceUpdated', (event) => {
        workspace.updateWorkspaceFromBroadcast(event)
      })

    window.Echo.private(`created_board.${workspaceId}`)
      .listen('BoardCreated', (event) => {
        workspace.addNewBoardFromBroadcast(event)
      })
  }

  return { listenPublicChannels, listenCurrentWorkspace }
}
